<div>
    <form wire:submit.prevent="submit">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" wire:model="name" placeholder="Enter name">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" wire:model="email" placeholder="Enter email">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <br>
        <button type="submit" class="btn btn-primary">{{ $edit !== null ? 'Update' : 'Submit' }}</button>
    </form>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($formData as $index => $data)
                <tr>
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['email'] }}</td>
                    <td>
                        <button wire:click="edit({{ $index }})" class="btn btn-warning btn-sm">Edit</button>
                        <button wire:click="delete({{ $index }})" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
