<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'email_required' => 'Email field is required.',
    'email' => 'Please enter valid email address.',
    'password_required' => 'Password field is required.',
    // 'username_regex' => 'The username must start with a letter and can only contain letters (uppercase or lowercase => numbers, underscores, or periods. It should be between 5 and 25 characters long.',
    'email_unique' => 'Email already exists.',
    'phone_min' =>  'Phone number should not less than 5 characters.',
    'phone_max' =>  'Phone number should not greater than 15 characters.',
    'phone_unique' =>  'Phone number already exists.',
    'password_min' =>   'Password should not less than 6 characters.',
    'confiremd' => 'Password does not match.',

    // Add Platform Validation Messages
    'platform_id_required' => 'Please enter valid platform.',
    'path_string' => 'Please enter valid path.',
    'label_max_length' => 'Lable max length is 25.',

    // Card Validation Messages
    'card_uuid_required_without' => 'Please enter card uuid or activation_code.',

    // Add Group Validatin Messages
    'title_required' => 'Title Field is required.',
    'title_string' => 'Title should be a string.',
    'title_min' => 'Title should not less than 2 characters.',
    'active_in' => 'Please select 0 or 1.',

    // Update Group Validation Messages
    'group_id_required' => 'Group id is required.',

    // Contact In Group Request
    'contact_id_required' => 'Contact Person id is required.',


    // Link Validation Messages
    'link_id_required' => 'Link Id is required.',
    'icon_mimes' => 'Only jepg, jpg and png is acceptable.',
    'icon_max' => 'Max size should be 2000 mb.',

    // Add Phone Contact Validation Message
    'contact_id_required' => 'Contact id is required.',
    'first_name_required' => 'First name is required.',
    'first_name_min' => 'First name not less than 2 characters.',
    'first_name_max' => 'First name not greater than 30 characters.',
    'last_name_min' => 'Last name not less than 2 characters.',
    'last_name_max' => 'Last name not greater than 30 characters.',
    'work_email_email' => 'Please enter valid email address.',
    'company_name_min' => 'Company name not less than 3 characters.',
    'company_name_max' => 'Company name not greater than 20 characters.',
    'job_title_max' => 'Job title not greater than 50 characters.',
    'address_min' => 'Address should not less than 3 characters.',
    'address_max' => 'Address should not greater than 110 characters.',
    'phone_required' => 'Phone is required.',
    'work_phone_min' => 'Work Phone should not less than 5 characters.',
    'work_phone_max' => 'Work Phone should not greater than 15 characters.',
    'photo_mimes' => 'Only jepg, jpg and png is acceptable.',
    'photo_max' => 'Max size should be 2000 mb.',

    // Increment Request
    'user_id_required' => 'User id is required.',

    // Update Profile Request

    'name_required' => 'Name field is required.',
    'name_min' => 'Name should not less than 3 characters.',
    'name_max' => 'Name should not greater than 20 characters.',

    'username_required' => 'Username field is required.',
    'username_min' => 'Username should not less than 5 characters.',
    'username_max' => 'Username should not greater than 25 characters.',
    'username_regex' => 'Username must contain letters, numbers and special chracters',
    'username_unique' => 'Username already exists.',
    'gender_in' => 'Please select 0 or 1.',
    'dob_date' => 'Please enter valid date.',
    'dob_before' => 'Date should be less than today.',
    'private_required' => 'Private filed is required.',
    'name_string' => 'Name should be a string.',
    'cover_photo_mimes' => 'Only jepg, jpg and png is acceptable.',
    'cover_photo_max' => 'Max size should be 4096 mb.',
    'job_title_string' => 'Job title should be string.',
    'company_string' => 'Company name should be string.',

    // 'username_required_without' => 'Please enter username, card uuid or connect_id.',
    // 'card_id_required_without' => 'Please enter username, card uuid or connect_id.',
    // 'connect_id_required_without' => 'Please enter username, card uuid or connect_id.',

    'search_profile_by_required' => 'Please enter uuid or id or username',

    'connect_id_required' => 'Connect Id field is required.'
];
