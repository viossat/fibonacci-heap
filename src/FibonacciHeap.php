<?php

/**
 * FibonacciHeap
 *
 * @author      Mathieu Viossat <mathieu@viossat.fr>
 * @copyright   Copyright (c) 2015 Mathieu Viossat
 * @license     http://opensource.org/licenses/MIT
 * @link        https://github.com/MathieuViossat/fibonacci-heap
 */

namespace MathieuViossat\Util;

class FibonacciHeap implements \Countable {

    protected $min;
    protected $n;

    public function __construct() {
        $this->min = null;
        $this->n = 0;
    }

    public function minimum() {
        return $this->min;
    }

    public function insert($key, $data) {
        if (!is_int($key) && !is_float($key))
            throw new \Exception('The key must be an integer or a float');

        $x = new FibonacciHeapElement();
        $x->key = $key;
        $x->data = $data;
        $x->left = $x;
        $x->right = $x;
        $this->min = $this->concatenate($x, $this->min);
        $this->n++;
        return $x;
    }

    public function extractMin() {
        $minimum = $this->min;
        if ($minimum !== null) {
            if ($minimum->child !== null) {
                $current = $minimum->child;
                while (true) {
                    $current->parent = null;
                    $current = $current->right;
                    if ($current === $minimum->child)
                        break;
                }
                $this->min = $this->concatenate($this->min, $minimum->child);
            }

            if ($minimum->right === $minimum) {
                $this->min = null;
            } else {
                $this->min = $minimum->right;
                $this->remove($minimum);
                $this->consolidate();
            }
            $this->n--;
        }
        return $minimum;
    }

    public function decreaseKey(FibonacciHeapElement $element, $key) {
        if (!is_int($key) && !is_float($key))
            throw new \Exception('The key must be an integer or a float');
        if ($key > $element->key)
            throw new \Exception('The new key must be lower than the old key');

        $element->key = $key;
        $y = $element->parent;

        if ($y !== null && $element->key < $y->key) {
            $this->cut($element, $y);
            $this->cascadingCut($y);
        }

        if ($element->key < $this->min->key)
            $this->min = $element;
    }

    public function delete(FibonacciHeapElement $element) {
        $this->decreaseKey($element, -PHP_INT_MAX-1);
        $this->extractMin();
    }

    public function merge(self $other) {
        $this->min = $this->concatenate($this->min, $other->min);
        $this->n = $this->n + $other->n;
    }

    public function isEmpty() {
        return $this->min === null;
    }

    public function size() {
        return $this->n;
    }

    public function count() {
        return $this->size();
    }

    public function clear() {
        $this->__construct();
    }

    protected function concatenate($x, $y) {
        if ($x === null)
            return $y;
        else if ($y === null)
            return $x;

        $savingXRight = $x->right;
        $x->right = $y->right;
        $x->right->left = $x;
        $y->right = $savingXRight;
        $y->right->left = $y;

        if ($x->key < $y->key)
            return $x;
        else
            return $y;
    }

    protected function remove(FibonacciHeapElement $x) {
        $x->left->right = $x->right;
        $x->right->left = $x->left;
        $x->right = $x;
        $x->left = $x;
    }

    protected function cut(FibonacciHeapElement $x, FibonacciHeapElement $y) {
        if ($x->right === $x) {
            $y->child = null;
        } else {
            $y->child = $x->right;
            $this->remove($x);
        }
        $y->degree--;
        $x->parent = null;
        $x->mark = false;
        $this->concatenate($this->min, $x);
    }

    protected function cascadingCut(FibonacciHeapElement $x) {
        $y = $x->parent;
        if ($y !== null) {
            if ($x->mark === false) {
                $x->mark = true;
            } else {
                $this->cut($x, $y);
                $this->cascadingCut($y);
            }
        }
    }

    protected function heapLink(FibonacciHeapElement $x, FibonacciHeapElement $y) {
        $this->remove($x);
        $this->concatenate($x, $y->child);
        $x->parent = $y;
        $y->child = $x;
        $y->degree++;
        $x->mark = false;
    }

    protected function consolidate() {
        $A = [];
        $rootList = [];
        $start = $this->min;
        $current = $start;

        while (true) {
            $rootList[] = $current;
            if ($current->right === $start)
                break;
            $current = $current->right;
        }

        foreach ($rootList as $x) {
            $d = $x->degree;
            while (isset($A[$d])) {
                $y = $A[$d];
                if ($x->key > $y->key) {
                    $tmp = $x;
                    $x = $y;
                    $y = $tmp;
                }
                $this->heapLink($y, $x);
                $A[$d] = null;
                $d++;
            }
            $A[$d] = $x;
        }

        $this->min = null;
        foreach ($A as $a) {
            if ($a !== null) {
                $this->remove($a);
                $this->min = $this->concatenate($a, $this->min);
            }
        }
    }

}
