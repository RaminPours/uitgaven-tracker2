<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Uitgaven Tracker</title>
</head>
<body  style="display: flex; flex-direction: column; align-items: center;">

    <h1>Persoonlijke Uitgaven Tracker</h1>

    <p>

        <a href="{{ route('categories.index') }}">Terug naar categorieën</a>

    </p>

    <h2>Nieuwe uitgave</h2>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('expenses.store') }}">
        @csrf

        <input type="text" name="title" placeholder="Omschrijving">

        <input type="number" step="0.01" name="amount" placeholder="Bedrag">

        <input type="date" name="date">

        <select name="category_id">
            <option value="">Kies categorie</option>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Opslaan</button>
    </form>   

    <hr>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Omschrijving</th>
                <th>Bedrag</th>
                <th>Datum</th>
                <th>Categorie</th>
                <th>Actie</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td>{{ $expense->title }}</td>
                    <td>€{{ number_format($expense->amount, 2, ',', '.') }}</td>
                    <td>{{ $expense->date }}</td>
                    <td>{{ $expense->category->name }}</td>
                    <td>
                        <form method="POST" action="{{ route('expenses.destroy', $expense) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <h2>Totaal per categorie</h2>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Categorie</th>
                <th>Totaal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($totalsPerCategory as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>€{{ number_format($category->expenses_sum_amount ?? 0, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
       
    </table>
     <tfoot>
            <p><strong>Totaal:</strong> €{{ number_format($totalAmount, 2, ',', '.') }}</p>
        </tfoot>
</body>
</html>