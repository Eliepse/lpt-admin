<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->addArgument('email',
            InputArgument::REQUIRED,
            'The email used by the user');
        $this->addArgument('firstname',
            InputArgument::REQUIRED,
            'The firstname of the user');
        $this->addArgument('lastname',
            InputArgument::REQUIRED,
            'The firstname of the user');

        $this->addOption('wechat',
            'w',
            InputOption::VALUE_OPTIONAL,
            'The wechat id of the admin');
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Eliepse\Set\Exceptions\UnknownMemberException
     */
    public function handle()
    {
        // Main attributes
        $validator = Validator::make($this->arguments(), [
            'email' => 'required|email|unique:users|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'wechat' => 'unique:users,wechat_id|max:255',
        ]);

        if ($validator->fails()) {
            $this->printFailedInputs($validator->errors(), "This user is not valid:");

            return;
        }

        // We make a new user
        $user = new User($this->arguments());
        $user->wechat_id = $this->option("wechat");
        $user->active = true;
        $user->type = 'staff';

        // Password
        $password = $this->secret("Please input a password (12 caracters minimum): ");

        $validator = Validator::make(['password' => $password], [
            'password' => 'required|string|min:12',
        ]);

        if ($validator->fails()) {
            $this->printFailedInputs($validator->errors(), "The password is not valid:");

            return;
        }

        $user->password = Hash::make($password);

        // Account type
        // We do not allow parent creation here, since it does not handle family links

        $role = $this->choice("Which kind of account do you want to create ?", ["admin", "teacher"]);
        $roles = $user->roles;
        $roles->set($role);
        $user->roles = $roles;

        // Confirmation
        $this->info("This user is about to be created:");

        foreach ($user->toArray() as $attribute => $value) {
            $this->info("$attribute: $value");
        }

        if (!$this->confirm("Do you confirm the creation of this user ?")) {
            $this->info("Creation aborted.");

            return;
        }

        $user->save();

        $this->info("User created.");
    }


    private function printFailedInputs(MessageBag $messageBag, string $message = null)
    {
        if (!empty($message)) {
            $this->error($message);
        }
        foreach ($messageBag->toArray() as $key => $error) {
            $this->warn("[$key] {$error[0]}");
        }
        $this->info("Creation aborted.");
    }
}
