<?php

namespace Illuminate\Database\Eloquent;

interface BuilderExtension
{
    public function apply(Builder &$builder);
}