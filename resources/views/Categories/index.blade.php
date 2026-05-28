<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Categorieën beheren</title>
</head>
<body style="display: flex; flex-direction: column; align-items: center;">

    <h1>Categorieën beheren</h1>

    <p> 

        <a href="{{ route('expenses.index') }}">Naar uitgaven</a>

    </p>



    <h2>Nieuwe categorie</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <input type="text" name="name" placeholder="Categorienaam">

        <button type="submit">Opslaan</button>
    </form>

    <h2>Alle categorieën</h2>

   <table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Verwijder categorie</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit">Verwijderen</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>