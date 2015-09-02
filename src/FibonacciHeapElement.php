<?php

/**
 * FibonacciHeapElement
 *
 * @author      Mathieu Viossat <mathieu@viossat.fr>
 * @copyright   Copyright (c) 2015 Mathieu Viossat
 * @license     http://opensource.org/licenses/MIT
 * @link        https://github.com/MathieuViossat/fibonacci-heap
 */

namespace MathieuViossat\Util;

class FibonacciHeapElement {

    public $left;
    public $right;
    public $parent;
    public $child;
    public $degree;
    public $mark;
    public $key;
    public $data;

    public function __construct() {
        $this->left = null;
        $this->right = null;
        $this->parent = null;
        $this->child = null;
        $this->degree = null;
        $this->mark = null;
        $this->key = 0;
        $this->data = null;
    }

    public function getKey() {
        return $this->key;
    }

    public function getData() {
        return $this->data;
    }

}
