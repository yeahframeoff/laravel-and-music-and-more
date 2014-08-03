<?php

namespace Karma\DataAccess;

interface SocialsRepository extends Repository
{
    public function byName($name);
}