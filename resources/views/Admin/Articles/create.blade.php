@extends('admin_layout')

@section('content')
    <h1>Criar Artigo</h1>
    @if (!empty($article))
        <h3>Inserção completa</h3>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger">
            <ul>
                    <li>{{ session('error') }}</li>
            </ul>
        </div>
    @elseif (session('success'))
        <h3>{{ session('success') }}</h3>
    @endif

    <form action="/article" method="POST">
        @csrf
        <label for="background">Capa</label>
        <input name="background" id="background" type="text" />

        <label for="title">Titulo</label>
        <input name="title" id="title" type="text" />

        <label for="author">Autor</label>
        <select name="author" id="author">
            <option value="O hermeneuta">O hermeneuta</option>
        </select>

        <label for="content">Conteudo</label>
        <div name="content" id="content"></div>

        <button>Enviar</button>
    </form>

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        var quill = new Quill('#content', {
            theme: 'snow' // Você também pode escolher o tema 'bubble'
        });
    </script>

@endsection
