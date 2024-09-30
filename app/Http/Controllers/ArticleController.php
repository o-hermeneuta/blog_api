<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ArticlePostRequest;
use App\Http\Requests\ArticleEditRequest;
use App\Http\Requests\TagRequest;
use App\Http\Requests\TagRemoveRequest;
use Illuminate\Support\Str;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleTagRepository;
use App\Enum\ArticleStatusEnum;

class ArticleController extends Controller
{

    public function index(){
        return view('Admin.Articles.index', ['page' => ArticleRepository::list(1)]);
    }

    public function create(){
        return view('Admin.Articles.create');
    }

    public function make(ArticlePostRequest $request) {
        $res = ArticleRepository::create($request->all());
        return redirect()->back()->with($res['status'], $res['value']);
    }

    public function edit($id, ArticleEditRequest $request) {
        $res = ArticleRepository::update($id, $request->all());
        return redirect()->back()->with($res['status'], $res['value']);
    }

    public function post($id) {
        $res = ArticleRepository::post($id);
        return redirect()->back()->with($res["status"], $res["value"]);
    }

    public function hide($id) {
        $res = ArticleRepository::hide($id);
        return redirect()->back()->with($res["status"], $res["value"]);
    }

    public function rate($id) {
        $res = ArticleRepository::rate($id);
        return redirect()->back()->with($res["status"], $res["value"]);
    }

    public function remove($id) {
        $res = ArticleRepository::delete($id);
        return redirect()->back()->with($res["status"], $res["value"]);
    }

    public function put_tag($article_id, TagRequest $request) {
        $res = ArticleTagRepository::putTag($article_id, $request->input('name'));
        return redirect()->back()->with($res["status"], $res["value"]);
    }

    public function remove_tag($article_id, TagRemoveRequest $request) {
        $res = ArticleTagRepository::removeTag($article_id, $request->input('name'));
        return redirect()->back()->with($res["status"], $res["value"]);
    }

    public function list_top() {
    }

    public function list_posts() {
    }
}
