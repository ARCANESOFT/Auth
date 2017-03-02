<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\ServiceProvider;
use Closure;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class     ValidatorServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ValidatorServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * The Validator instance.
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $this->validator = $app['validator'];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->registerUserValidators();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /* ------------------------------------------------------------------------------------------------
     |  Validators
     | ------------------------------------------------------------------------------------------------
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

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Extend validator.
     *
     * @param  string         $name
     * @param  string         $class
     * @param  \Closure|null  $replacer
     */
    private function extendValidator($name, $class, Closure $replacer = null)
    {
        $this->validator->extend($name, "{$class}@validate" . studly_case($name));

        if ( ! is_null($replacer))
            $this->validator->replacer($name, $replacer);
    }
}
