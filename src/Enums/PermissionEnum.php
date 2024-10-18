<?php

namespace LaraJS\Permission\Enums;

enum PermissionEnum
{
    case MANAGE;
    case VISIT;
    case CREATE;
    case EDIT;
    case DELETE;
    case VIEW_MENU_ROLE_PERMISSION;
    case VIEW_MENU_USER;
}
