<?php

$designation_array = [
    1 => 'CEO',
    2 => 'Manager',
    3 => 'Assistant Manager',
    4 => 'Senior Executive',
    5 => 'Executive',
    6 => 'Junior Executive',
    7 => 'Trainee',
    8 => 'Intern',
];

$department_array = [
    1 => 'Management',
    2 => 'Marketing',
    3 => 'Sales',
    4 => 'Finance',
    5 => 'Human Resource',
    6 => 'Information Technology',
    7 => 'Customer Service',
    8 => 'Research and Development',
    9 => 'Production',
    10 => 'Logistics',
    11 => 'Procurement',
    12 => 'Legal',
    13 => 'Administration',
    14 => 'Security',
    15 => 'Other',
];

$blood_group_array = [
    1 => 'A+',
    2 => 'A-',
    3 => 'B+',
    4 => 'B-',
    5 => 'O+',
    6 => 'O-',
    7 => 'AB+',
    8 => 'AB-',
];

$marital_status_array = [
    1 => 'Married',
    2 => 'Unmarried',
    3 => 'Divorced',
    4 => 'Widowed',
    5 => 'Separated',
];

$bank_name_array = [
    1 => 'Sonali Bank',
    2 => 'Janata Bank',
    3 => 'Agrani Bank',
    4 => 'Rupali Bank',
    6 => 'Islami Bank Bangladesh Limited',
    7 => 'Pubali Bank',
    8 => 'Dutch Bangla Bank Limited',
    9 => 'Brac Bank Limited',
    10 => 'Eastern Bank Limited',
    11 => 'Mercantile Bank Limited',
    12 => 'Mutual Trust Bank',
    13 => 'National Bank',
    14 => 'One Bank',
    15 => 'Premier Bank',
    16 => 'Prime Bank',
    17 => 'South East Bank',
    18 => 'Standard Bank',
    19 => 'Trust Bank',
    20 => 'United Commercial Bank',
    21 => 'IFIC Bank',
    22 => 'NRB Bank',
    23 => 'Bank Asia',
    24 => 'City Bank Limited',
    25 => 'Shahjalal Islami Bank',
    26 => 'Jamuna Bank',
    27 => 'NCC Bank',
    28 => 'NRB Commercial Bank',
    29 => 'Midland Bank',
    30 => 'Al-Arafah Islami Bank',
    31 => 'Modhumoti Bank',
    32 => 'NRB Global Bank',
    33 => 'NRB Bank',
    34 => 'NRB Commercial Bank'
];

$month_array = [
    1 => 'January',
    2 => 'February',
    3 => 'March',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'August',
    9 => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];


// designations dropdown function
function designations_dropdown($designation_array, $designation = null)
{
    $dropdown = '<select class="form-control" name="designation" id="designation">';
    $dropdown .= '<option value="">Select Designation</option>';
    foreach ($designation_array as $key => $value) {
        if ($designation == $key) {
            $dropdown .= '<option value="' . $key . '" selected>' . $value . '</option>';
        } else {
            $dropdown .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    $dropdown .= '</select>';
    return $dropdown;
}

// departments dropdown function
function departments_dropdown($department_array, $department = null)
{
    $dropdown = '<select class="form-control" name="department" id="department">';
    $dropdown .= '<option value="">Select Department</option>';
    foreach ($department_array as $key => $value) {
        if ($department == $key) {
            $dropdown .= '<option value="' . $key . '" selected>' . $value . '</option>';
        } else {
            $dropdown .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    $dropdown .= '</select>';
    return $dropdown;
}

// blood groups dropdown function
function blood_groups_dropdown($blood_group_array, $blood_group = null)
{
    $dropdown = '<select class="form-control" name="blood_group" id="blood_group">';
    $dropdown .= '<option value="">Select Blood Group</option>';
    foreach ($blood_group_array as $key => $value) {
        if ($blood_group == $key) {
            $dropdown .= '<option value="' . $key . '" selected>' . $value . '</option>';
        } else {
            $dropdown .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    $dropdown .= '</select>';
    return $dropdown;
}

// marital statuses dropdown function
function marital_statuses_dropdown($marital_status_array, $marital_status = null)
{
    $dropdown = '<select class="form-control" name="marital_status" id="marital_status">';
    $dropdown .= '<option value="">Select Marital Status</option>';
    foreach ($marital_status_array as $key => $value) {
        if ($marital_status == $key) {
            $dropdown .= '<option value="' . $key . '" selected>' . $value . '</option>';
        } else {
            $dropdown .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    $dropdown .= '</select>';
    return $dropdown;
}

// bank names dropdown function
function bank_names_dropdown($bank_name_array, $bank_name = null)
{
    $dropdown = '<select class="form-control" name="bank_name" id="bank_name">';
    $dropdown .= '<option value="">Select Bank Name</option>';
    foreach ($bank_name_array as $key => $value) {
        if ($bank_name == $key) {
            $dropdown .= '<option value="' . $key . '" selected>' . $value . '</option>';
        } else {
            $dropdown .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    $dropdown .= '</select>';
    return $dropdown;
}

// searchOption dropdown function
function searchOptionDropdown($searchOption = null)
{
    $dropdown = '<select class="form-control" name="searchOption" id="searchOption">';
    $dropdown .= '<option value="">Select Option</option>';
    $dropdown .= '<option value="1" ' . ($searchOption == 1 ? 'selected' : '') . '>Year & Month Wise</option>';
    $dropdown .= '<option value="2" ' . ($searchOption == 2 ? 'selected' : '') . '>From Date & To Date Wise</option>';
    $dropdown .= '</select>';
    return $dropdown;
}

// year dropdown function
function yearsDropdown($year = null)
{
    $years_array = array_combine((range(date('Y'), date('Y') - 10)),(range(date('Y'), date('Y') - 10)));
    $dropdown = '<select class="form-control" name="year" id="year">';
    $dropdown .= '<option value="">Select Option</option>';
    foreach ($years_array as $key => $value) {
        if ($year == $key) {
            $dropdown .= '<option value="' . $key . '" selected>' . $value . '</option>';
        } else {
            $dropdown .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    $dropdown .= '</select>';
    return $dropdown;
}

//months dropdown function
function monthsDropdown($month = null)
{
    $monthArray = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];
    $dropdown = '<select class="form-control" name="month" id="month">';
    $dropdown .= '<option value="">Select Option</option>';
    foreach ($monthArray as $key => $value) {
        if ($month == $key) {
            $dropdown .= '<option value="' . $key . '" selected>' . $value . '</option>';
        } else {
            $dropdown .= '<option value="' . $key . '">' . $value . '</option>';
        }
    }
    $dropdown .= '</select>';
    return $dropdown;
}

?>
