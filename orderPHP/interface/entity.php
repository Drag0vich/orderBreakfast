<?php

namespace Order;

interface Entity {
    static function fromArray($array);
    function toArray();
}