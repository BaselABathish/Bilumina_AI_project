<form action="/search" method="POST">
    @csrf
    <input type="text" name="query" required placeholder="Enter search text">
    <button type="submit">Search</button>
</form>

@isset($results)
    <div class="results">
        @foreach($results as $result)
            <div>{{ $result['item_name'] }} (Similarity: {{ $result['similarity'] }})</div>
        @endforeach
    </div>
@endisset
