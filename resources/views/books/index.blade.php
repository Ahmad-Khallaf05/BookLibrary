<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }
        .book-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .book-card {
            display: flex;
            align-items: center;
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }
        .book-card img {
            max-width: 150px;
            max-height: 200px;
            margin-right: 20px;
            object-fit: cover;
            border-radius: 5px;
        }
        .book-info {
            flex: 1;
        }
        .book-info h2 {
            margin: 0;
            font-size: 20px;
            margin-bottom: 5px;
        }
        .book-info p {
            margin: 0;
            color: #666;
        }
        .authors-list span {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 14px;
            margin-right: 5px;
            margin-top: 5px;
        }
        .actions {
            display: flex;
            align-items: center;
        }
        .actions a, .actions form {
            margin-left: 10px;
        }
        .actions a {
            color: white;
            background-color: #007bff;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .actions a:hover {
            background-color: #0056b3;
        }
        .actions button {
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        .actions button:hover {
            background-color: #cc0000;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Books List</h1>
        <a href="{{ route('books.create') }}" style="display: block; margin-bottom: 20px; padding: 10px 15px; background-color: #28a745; color: white; text-align: center; text-decoration: none; border-radius: 5px; font-size: 16px;">Add New Book</a>
        @if (session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        <ul class="book-list">
            @foreach ($books as $book)
                <li class="book-card">
                    @if ($book->image)
                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->name }}">
                    @else
                        <img src="https://via.placeholder.com/150x200" alt="No Image">
                    @endif
                    <div class="book-info">
                        <h2>{{ $book->name }}</h2>
                        <p>{{ $book->description }}</p>
                        <div class="authors-list">
                            <strong>Authors:</strong>
                            @foreach ($book->authors as $author)
                                <span>{{ $author->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="actions">
                        <a href="{{ route('books.edit', $book->id) }}">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this book?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
