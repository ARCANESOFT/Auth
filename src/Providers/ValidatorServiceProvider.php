<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\ServiceProvider;
use Closure;

/**
 * Class     ValidatorServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ValidatorServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->registerUserValidators();
    }

    /* -----------------------------------------------------------------
     |  Validators
     | -----------------------------------------------------------------
     */

    /**
     * Register the user validators.
     */
    private function registerUserValidators()
    {
        $this->extendValidator(
            'user_password',
            \Arcanesoft\Auth\Validators\UserValidator::class,
            function($message, $attribute) {
                $message = 'auth::validation.user_password';

                return str_replace(':attribute', $attribute, trans($message));
            }
        );
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the validator instance.
     *
     * @return \Illuminate\Validation\Factory
     */
    private function validator()
    {
        return $this->app['validator'];
    }

    /**
     * Extend validator.
     *
     * @param  string         $name
     * @param  string         $class
     * @param  \Closure|null  $replacer
     */
    private function extendValidator($name, $class, Closure $replacer = null)
    {
        $this->validator()->extend($name, "{$class}@validate" . studly_case($name));

        if ( ! is_null($replacer))
            $this->validator()->replacer($name, $replacer);
    }
}
