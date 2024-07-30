<?php

namespace App\Http\Livewire\Admin;

use App\Models\Card;
use App\Models\Category;
use App\Models\Platform;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{

    public $users = 0, $categories = 0, $platforms = 0, $cards = 0, $registrations, $days = 7;

    public function mount()
    {
        $this->users = User::all()->count();
        $this->categories = Category::all()->count();
        $this->platforms = Platform::all()->count();
        $this->cards = Card::all()->count();

        $this->registrations = $this->usersChartData($this->days);
    }

    public function updatedDays()
    {
        $this->registrations = $this->usersChartData($this->days);
        $this->dispatchBrowserEvent('showData', [
            'registrations' => $this->registrations,
            'days' => $this->days
        ]);
    }

    public function usersChartData($days)
    {
        $total_days = $days;
        // $total_days = Carbon::create(Transaction::min('created_at'))->diffInDays(Carbon::create(Transaction::max('created_at')));

        $firstDate = Carbon::now()->subDays($total_days);
        $lastDate = Carbon::create($firstDate)->addDays($total_days);

        // $firstDate = Carbon::create(Transaction::max('created_at'))->subDays($total_days);
        // $lastDate = Carbon::create($firstDate)->addDays($total_days);


        $registrations = DB::table('users')
            ->select(DB::raw('DATE(created_at) as created_date, COUNT(*) as user_count'))
            ->whereBetween('created_at', [$firstDate, $lastDate])
            ->groupBy('created_date')
            ->get();



        $registrations->map(function ($item, $key) use ($registrations) {
            if ($key > 0) {
                $previousItem = $registrations[$key - 1];
                $date1 = Carbon::create($previousItem->created_date);
                $date2 = Carbon::create($item->created_date);
                $diff = $date1->diffInDays($date2);

                if ($diff > 1) {
                    for ($i = 1; $i < $diff; $i++) {
                        $newDate = $date1->addDay()->format('Y-m-d');
                        $registrations->push((object)[
                            'created_date' => $newDate,
                            'user_count' => 0,
                        ]);
                    }
                }
            }
            return $item;
        });

        if ($registrations->count() > 1) {

            if ($registrations->min('created_date') != $firstDate->toDateString()) {
                $date1 = Carbon::create($firstDate->toDateString());
                $date2 = Carbon::create($registrations[0]->created_date);
                $diff = $date1->diffInDays($date2);

                for ($i = 0; $i < $diff; $i++) {
                    $newDate = $date1->clone()->addDays($i)->format('Y-m-d');
                    $registrations->push((object)[
                        'created_date' => $newDate,
                        'user_count' => 0,
                    ]);
                }
            }

            if ($registrations->max('created_date') != $lastDate->toDateString()) {

                $date1 = Carbon::create($registrations->max('created_date'));
                $date2 = Carbon::create($lastDate->toDateString());
                $diff = $date1->diffInDays($date2);

                for ($i = 1; $i < $diff + 1; $i++) {
                    $newDate = $date1->clone()->addDays($i)->format('Y-m-d');
                    $registrations->push((object)[
                        'created_date' => $newDate,
                        'user_count' => 0,
                    ]);
                }
            };
        }

        return json_encode(array_values($registrations->sortBy('created_date')->toArray()));
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.app');
    }
}
