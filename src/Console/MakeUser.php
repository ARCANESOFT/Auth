<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Console;

use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Repositories\UsersRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Closure;

/**
 * Class     MakeUser
 *
 * @package  Arcanesoft\Auth\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class MakeUser extends Command
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:user {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the command.
     */
    public function handle(): void
    {
        $this->line('');
        $this->comment('Creating a new User');

        call_user_func(static::defaultCreateUserCallback(), ...[
            $this->ask('First Name'),
            $this->ask('Last Name'),
            $this->ask('Email Address'),
            $this->secret('Password'),
            $this->option('admin')
        ]);

        $this->comment('User created successfully.');
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the default callback used for creating new Nova users.
     *
     * @return \Closure
     */
    protected static function defaultCreateUserCallback(): Closure
    {
        return function (string $firstName, string $lastName, string $email, string $password, bool $isAdmin) {
            /** @var  \Arcanesoft\Auth\Repositories\UsersRepository  $repo */
            $repo = app(UsersRepository::class);
            $now  = Date::now();
            $user = $repo->forceCreate([
                'first_name'        => $firstName,
                'last_name'         => $lastName,
                'email'             => $email,
                'email_verified_at' => $now,
                'password'          => $password,
                'is_admin'          => $isAdmin,
                'activated_at'      => $now
            ]);

            $repo->syncRolesByKeys($user, $isAdmin ? [Role::ADMINISTRATOR] : [Role::MEMBER]);
        };
    }
}
