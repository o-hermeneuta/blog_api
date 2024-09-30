@extends('admin_layout')

@section('content')
    <form>
        <input type="text" />
        <button>Pesquisar</button>
    </form>
    <h1>Artigos</h1>
    <a href="/articles/create">criar</a>
    @foreach ($page['items'] as $article)
        <article>
            <h2>{{$article->title}}</h2>
            <a>editar</a>
            <a>remover</a>
        </article>
    @endforeach
@endsection
