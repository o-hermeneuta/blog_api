<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticlePostRequest;
use Illuminate\Support\Str;
use App\Repositories\ArticleRepository;
use App\Enum\ArticleStatusEnum;

class ArticleController extends Controller
{

    public function index(){
        return view('Admin.Articles.index', ['articles' => Article::all()]);
    }

    public function create(){
        return view('Admin.Articles.create');
    }

    public function make(ArticlePostRequest $request) {
        $article = ArticleRepository::create($request->all());
        return redirect()->back()->with($article['status'], $article['value']);
    }

    public function edit() {
    }

    public function post($id) {
        $article = ArticleRepository::post($id);
        return redirect()->back()->with($article["status"],$article["value"]);
    }

    public function hide($id) {
        $article = ArticleRepository::hide($id);
        return redirect()->back()->with($article["status"],$article["value"]);
    }

    public function rate($id) {
        $article = ArticleRepository::rate($id);
        return redirect()->back()->with($article["status"],$article["value"]);
    }

    public function remove($id) {
        $article = ArticleRepository::delete($id);
        return redirect()->back()->with($article["status"],$article["value"]);
    }

    public function put_tag() {
    }

    public function remove_tag() {
    }

    public function list_top() {
    }

    public function list_posts() {
    }
}
