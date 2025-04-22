<?php

return [
    // Auth messages
    'auth' => [
        'login_success' => 'Login successful',
        'logout_success' => 'Logout successful',
        'invalid_credentials' => 'Invalid credentials',
        'token_refreshed' => 'Token refreshed',
        'reset_code_sent' => 'Reset code sent to your email',
        'password_reset' => 'Password reset successful',
        'token_expired' => 'Token expired',
        'token_invalid' => 'Invalid token',
        'user_not_found' => 'User not found',
        'processing_error' => 'An error occurred while processing your request',
        'reset_error' => 'An error occurred while resetting the password',
        'validation_error' => 'Validation error',
        'email_required' => 'Email is required',
        'password_required' => 'Password is required',
        'token_required' => 'Token is required',
        'token_invalid_format' => 'Token must be 6 digits',
        'password_min_length' => 'Password must be at least 8 characters',
        'password_confirmation' => 'Password confirmation does not match',
    ],

    // Shop messages
    'shop' => [
        'created' => 'Shop created',
        'updated' => 'Shop updated',
        'deleted' => 'Shop deleted',
        'not_found' => 'Shop not found',
    ],

    // Favorite messages
    'favorite' => [
        'added' => 'Added to favorites',
        'removed' => 'Removed from favorites',
        'already_exists' => 'Already in favorites',
        'not_found' => 'Not in favorites',
    ],

    // Review messages
    'review' => [
        'created' => 'Review created successfully',
        'updated' => 'Review updated successfully',
        'deleted' => 'Review deleted successfully',
        'not_found' => 'Review not found',
        'unauthorized' => 'You are not authorized to perform this action',
        'rating_required' => 'Rating is required',
        'rating_range' => 'Rating must be between 0 and 5',
        'type_required' => 'Type is required',
        'type_invalid' => 'Type must be good, neutral, or bad',
    ],

    // Shop Hours messages
    'shop_hours' => [
        'created' => 'Shop hours created successfully',
        'updated' => 'Shop hours updated successfully',
        'deleted' => 'Shop hours deleted successfully',
        'not_found' => 'Shop hours not found',
        'unauthorized' => 'You are not authorized to manage shop hours',
        'weekday_required' => 'Weekday is required',
        'weekday_range' => 'Weekday must be between 0 and 6',
        'weekday_unique' => 'This weekday already has hours defined',
        'time_required' => 'Time is required',
        'time_format' => 'Time must be in H:i:s format',
    ],

    // Reservation messages
    'reservation' => [
        'created' => 'Reservation created successfully',
        'updated' => 'Reservation updated successfully',
        'deleted' => 'Reservation deleted successfully',
        'not_found' => 'Reservation not found',
        'unauthorized' => 'You are not authorized to manage this reservation',
        'status_required' => 'Status is required',
        'status_invalid' => 'Status must be pending, confirmed, or canceled',
        'date_required' => 'Date is required',
        'date_format' => 'Date must be in Y-m-d format',
        'no_slots' => 'No available slots found for the selected date',
        'shop_required' => 'Shop ID is required',
        'shop_exists' => 'Selected shop does not exist',
        'service_required' => 'Service ID is required',
        'service_exists' => 'Selected service does not exist',
        'scheduled_at_required' => 'Scheduled date and time is required',
        'scheduled_at_format' => 'Scheduled date and time must be in Y-m-d H:i:s format',
        'scheduled_at_future' => 'Scheduled date and time must be in the future',
        'scheduled_at_business_hours' => 'Scheduled time must be within business hours',
        'service_not_available' => 'Selected service is not available at this shop',
        'slot_not_available' => 'Selected time slot is not available',
    ],

    // Shop Service messages
    'shop_service' => [
        'created' => 'Service added to shop successfully',
        'updated' => 'Service price updated successfully',
        'deleted' => 'Service removed from shop successfully',
        'not_found' => 'Service not found',
        'unauthorized' => 'You are not authorized to manage shop services',
        'service_required' => 'Service ID is required',
        'service_exists' => 'Selected service does not exist',
        'price_required' => 'Price is required',
        'price_numeric' => 'Price must be a number',
        'price_min' => 'Price must be greater than or equal to 0',
        'already_exists' => 'This service is already added to the shop',
    ],

    // Error messages
    'error' => [
        'server_error' => 'Server error',
        'validation_error' => 'Validation error',
        'unauthorized' => 'Unauthorized',
        'not_found' => 'Not found',
    ],
];
