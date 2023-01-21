<?php

namespace Shashin\User\Enum;

enum UserError: string
{
    case NOT_ADMIN = 'user.not.admin';
    case EMAIL_ALREADY_EXISTS = 'user.email.already_exists';
    case REGISTRATION_FAILED = 'user.registration.failed';
    case NOT_FOUND = 'user.not.found';
    case WRONG_PASSWORD = 'user.wrong.password';
}
