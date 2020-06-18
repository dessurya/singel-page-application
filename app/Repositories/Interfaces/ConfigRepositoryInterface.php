<?php

namespace App\Repositories\Interfaces;

interface ConfigRepositoryInterface {
    public function menu($roll);
    public function index($request);
    public function tabList($request);
}