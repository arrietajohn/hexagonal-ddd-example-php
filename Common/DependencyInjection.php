<?php

declare(strict_types=1);

require_once __DIR__ . '/ClassLoader.php';
require_once __DIR__ . '/EnvLoader.php';

final class DependencyInjection
{
    public static function boot(): void
    {
        EnvLoader::load(dirname(__DIR__) . '/.env');
        ClassLoader::register();
    }

    public static function getConnection(): Connection
    {
        ClassLoader::loadClass('Connection');

        return new Connection(
            host:     EnvLoader::get('DB_HOST',     '127.0.0.1'),
            port:     EnvLoader::getInt('DB_PORT',  3306),
            database: EnvLoader::get('DB_DATABASE', 'crud_usuarios'),
            username: EnvLoader::get('DB_USERNAME', 'root'),
            password: EnvLoader::get('DB_PASSWORD', ''),
            charset:  EnvLoader::get('DB_CHARSET',  'utf8mb4')
        );
    }

    public static function getPdo(): PDO
    {
        return self::getConnection()->createPdo();
    }

    public static function getUserPersistenceMapper(): UserPersistenceMapper
    {
        ClassLoader::loadClass('UserPersistenceMapper');

        return new UserPersistenceMapper();
    }

    public static function getUserRepository(): UserRepositoryMySQL
    {
        ClassLoader::loadClass('UserRepositoryMySQL');

        return new UserRepositoryMySQL(
            self::getPdo(),
            self::getUserPersistenceMapper()
        );
    }

    public static function getCreateUserUseCase(): CreateUserUseCase
    {
        ClassLoader::loadClass('CreateUserService');

        $repository = self::getUserRepository();

        return new CreateUserService(
            $repository,
            $repository
        );
    }

    public static function getUpdateUserUseCase(): UpdateUserUseCase
    {
        ClassLoader::loadClass('UpdateUserService');

        $repository = self::getUserRepository();

        return new UpdateUserService(
            $repository,
            $repository,
            $repository
        );
    }

    public static function getGetUserByIdUseCase(): GetUserByIdUseCase
    {
        ClassLoader::loadClass('GetUserByIdService');

        return new GetUserByIdService(
            self::getUserRepository()
        );
    }

    public static function getGetAllUsersUseCase(): GetAllUsersUseCase
    {
        ClassLoader::loadClass('GetAllUsersService');

        return new GetAllUsersService(
            self::getUserRepository()
        );
    }

    public static function getDeleteUserUseCase(): DeleteUserUseCase
    {
        ClassLoader::loadClass('DeleteUserService');

        $repository = self::getUserRepository();

        return new DeleteUserService(
            $repository,
            $repository
        );
    }

    public static function getUserWebMapper(): UserWebMapper
    {
        ClassLoader::loadClass('UserWebMapper');

        return new UserWebMapper();
    }

    public static function getUserController(): UserController
    {
        ClassLoader::loadClass('UserController');

        return new UserController(
            self::getCreateUserUseCase(),
            self::getUpdateUserUseCase(),
            self::getGetUserByIdUseCase(),
            self::getGetAllUsersUseCase(),
            self::getDeleteUserUseCase(),
            self::getUserWebMapper()
        );
    }

    public static function getLoginUseCase(): LoginUseCase
    {
        ClassLoader::loadClass('LoginService');

        return new LoginService(
            self::getUserRepository()
        );
    }
}