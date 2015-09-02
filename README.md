# Fibonacci heap

The Fibonacci heap is a heap data structure with the best amortized running time.
It was developed by Michael L. Fredman and Robert E. Tarjan in 1984.
The running time of Dijkstra's algorithm can be improved to O(|E| + |V| log |V|) by using a Fibonacci heap.

## Installation

```
composer require mathieuviossat/fibonacci-heap
```

```json
{
    "require": {
        "mathieuviossat/fibonacci-heap": "~1.0.0"
    }
}
```

## Example

```php
use MathieuViossat\Util\FibonacciHeap;

$movies = new FibonacciHeap();

$movies->insert(4, 'The Phantom Menace');
$movies->insert(5, 'Attack of the Clones');
$movies->insert(6, 'Revenge of the Sith');
$movies->insert(1, 'A New Hope');
$movies->insert(2, 'The Empire Strikes Back');
$movies->insert(3, 'Return of the Jedi');
$movies->insert(7, 'The Force Awakens');

while ($movie = $movies->extractMin())
    echo $movie->getKey() . ' - ' . $movie->getData() . PHP_EOL;
```

## Methods

#### minimum() : FibonacciHeapElement
Returns the element with the lowest key, or null if the heap is empty.   
Complexity: Θ(1)

#### insert(int $key, mixed $data) : FibonacciHeapElement
Inserts $data with the priority $key in the heap and return the element.   
Complexity: Θ(1)

#### extractMin() : FibonacciHeapElement
Deletes the element with the lowest priority from the heap and return it.   
Amortized complexity: O(log n)

#### decreaseKey(FibonacciHeapElement $element, int $key) : void
Replaces $element's key by $key. $key must be lower than the old key.   
Amortized complexity: Θ(1)

#### delete(FibonacciHeapElement $element) : void
Deletes $element from the heap.   
Amortized complexity: O(log n)

#### merge(FibonacciHeap $other) : void
Merges the both heaps. I recommend to only use one of them after that.   
Complexity: Θ(1)

#### isEmpty() : bool
Retuns true if the heap is empty, false otherwise.   
Complexity: Θ(1)

#### size() / count() / count($heap) : int
Retuns the number of elements in the heap.   
Complexity: Θ(1)

#### clear() : void
Removes all elements from the heap.   
Complexity: Θ(1)

## License

This library is published under [The MIT License](http://opensource.org/licenses/MIT).
