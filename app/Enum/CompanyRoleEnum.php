<?php

namespace App\Enum;

enum CompanyRoleEnum: string
{
    case ANALYST = 'analyst';
    case MANAGER = 'manager';
    case DESIGNER = 'designer';
    case LEAD = 'lead';
    case TESTER = 'tester';
    case BACKEND = 'backend';
    case FRONTEND = 'frontend';
    case DEVOPS = 'devops';
    case INTERN = 'intern';

}
