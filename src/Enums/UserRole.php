<?php

namespace SE\SDK\Enums;

final class UserRole
{
    const Admin = "Admin";
    const Manager = "Manager";
    const User = "User";
    const SuperAuthor = "SuperAuthor"; //это была роль для авторов на пять сфер, что б публиковали без редактуры
    const Author = "Author"; // это роль авторов для создания продуктов
    const DemoAuthor = "DemoAuthor"; // это роль для автора на создание продуктов с ограниченными возможностями
}