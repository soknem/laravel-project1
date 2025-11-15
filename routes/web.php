<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;


Route::get('/year/{year?}', function ($year = null) {
    $defaultYear = Carbon::now()->year;
    $year = $year ?? $defaultYear;

    if ($year == 2025) {
        $message = 'Hello this is year 2025.';
    } elseif ($year == $defaultYear) {
        $message = "No year provided, defaulting to the current year ($defaultYear).";
    } else {
        $message = "You provided year $year.";
    }
    
    return [
        'param_name' => 'year',
        'input_value' => $year,
        'default_used_if_empty' => $defaultYear,
        'message' => $message,
    ];
})->where('year', '[0-9]+');


Route::get('/year/month/{month?}', function (int $month = null) {
    $defaultMonth = Carbon::now()->month;
    $month = $month ?? $defaultMonth;

    $months = [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
    ];
    
    $monthName = $months[$month] ?? "Invalid month number ($month).";
    
    if ($month == $defaultMonth) {
        $status = "No month provided, defaulting to the current month ($monthName).";
    } else {
        $status = "The month requested is $monthName.";
    }

    return [
        'param_name' => 'month',
        'input_number' => $month,
        'default_used_if_empty' => $defaultMonth,
        'month_name' => $monthName,
        'message' => $status,
    ];
})->where('month', '[1-9]|1[0-2]');


Route::get('/date/offset/{days?}', function (int $days = 0) {
    
    $targetDate = Carbon::today()->addDays($days);
    
    if ($days > 0) {
        $message = "The date is $days days from today.";
    } elseif ($days < 0) {
        $message = "The date was " . abs($days) . " days ago.";
    } else {
        $message = "No offset provided, defaulting to today (0 days).";
    }

    return [
        'param_name' => 'days',
        'input_offset' => $days,
        'default_used_if_empty' => 0,
        'current_date' => Carbon::now()->toDateString(),
        'target_date' => $targetDate->toDateString(),
        'message' => $message,
    ];
})->where('days', '-?[0-9]+');