<?php

return [
    'heading' => 'Reset Password',
    'submit'  => 'Send Password Reset Link',
    'links'   => [
        'login'    => 'You\'ve remembered your password ? Sign in',
        'register' => 'Don\'t have an account ? Sign up',
    ],
    'mail'    => [
        'subject' => 'Reset Password - ' . config('app.name'),
        'line-1'  => 'You are receiving this email because we received a password reset request for your account.',
        'line-2'  => 'If you did not request a password reset, no further action is required.',
        'action'  => 'Reset Password',
    ],
    'reset' => [
        'submit' => 'Reset',
    ],
];
