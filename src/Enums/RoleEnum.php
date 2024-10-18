<?php

namespace LaraJS\Permission\Enums;

enum RoleEnum
{
    case ADMIN;
    case MANAGER;
    case VISITOR;
    case CREATOR;
    case EDITOR;
    case DELETER;
}
