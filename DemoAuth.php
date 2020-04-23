<?php

namespace Filegator\Services\Auth\Adapters;

use Filegator\Services\Auth\AuthInterface;
use Filegator\Services\Auth\User;
use Filegator\Services\Auth\UsersCollection;
use Filegator\Services\Service;
use Filegator\Services\Session\SessionStorageInterface as Session;
use Filegator\Utils\PasswordHash;

class DemoAuth implements Service, AuthInterface
{
    const SESSION_KEY = 'demo_auth';

    protected $session;

    protected $name = 'John Doe';
    protected $username = 'john@example.com';
    protected $password = 'demo123';
    protected $permissions = ['read', 'write', 'upload', 'download', 'batchdownload', 'zip'];
    protected $role = 'user';
    protected $homedir = '/';

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function init(array $config = [])
    {
        if (isset($config['password'])) {
            $this->password = $config['password'];
        }

        if (isset($config['permissions'])) {
            $this->permissions = $config['permissions'];
        }

        if (isset($config['homedir'])) {
            $this->homedir = $config['homedir'];
        }

        if (isset($config['role'])) {
            $this->role = $config['role'];
        }

        if (isset($config['name'])) {
            $this->name = $config['name'];
        }

        if (isset($config['username'])) {
            $this->username = $config['username'];
        }
    }

    public function user(): ?User
    {
        return $this->session ? $this->session->get(self::SESSION_KEY, null) : null;
    }

    public function authenticate($username, $password): bool
    {
        if ($username == $this->username && $password == $this->password) {
            $this->store($this->getDemoUser());
            return true;
        }

        return false;
    }

    public function forget()
    {
        return $this->session->invalidate();
    }

    public function store(User $user)
    {
        return $this->session->set(self::SESSION_KEY, $user);
    }

    public function update($username, User $user, $password = ''): User
    {
        return $this->getDemoUser();
    }

    public function add(User $user, $password): User
    {
        return $this->getDemoUser();
    }

    public function delete(User $user)
    {
        return true;
    }

    public function find($username): ?User
    {
        return $this->getDemoUser();
    }

    public function allUsers(): UsersCollection
    {
        $users = new UsersCollection();

        $users->addUser($this->getDemoUser());

        return $users;
    }

    protected function getDemoUser(): User
    {
        $new = new User();

        $new->setUsername($this->username);
        $new->setName($this->name);
        $new->setRole($this->role);
        $new->setHomedir($this->homedir);
        $new->setPermissions($this->permissions);

        return $new;
    }

    public function getGuest(): User
    {
        $new = new User();

        $new->setUsername('guest');
        $new->setName('Guest');
        $new->setRole('guest');
        $new->setHomedir('');
        $new->setPermissions([]);

        return $new;
    }


}
