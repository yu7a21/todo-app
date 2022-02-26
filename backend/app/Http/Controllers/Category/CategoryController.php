<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\TodoApp\Category\Domain\CategoryForm;
use App\TodoApp\Category\UseCase\CategoryUseCase;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __invoke(Request $request, CategoryUseCase $use_case)
    {
        $category_form_array = [];
        //全カテゴリのデータがPOSTされてくるので、ひとつづつformに入れる
        foreach ($request->request as $key => $val) {
            //TODO:オブジェクト作れ
            //TODO:配列じゃなくてコレクションクラスにしたほうがいい
            $category_delete_list = [];
            //csrfトークンをスキップ
            if ($key === "_token") {
                continue;
            //新しいカテゴリはidがないので個別に対応
            } else if ($key === "category_new") {
                $category_form_array[] = new CategoryForm(null, $val);
            //削除カテゴリリストは別処理にする
            } else if ($key === "category_delete_list") {
                $category_delete_list = explode(',', $val);
            } else {
                //TODO:配列じゃなくてコレクションクラスにしたほうがいい
                $category_form_array[] = new CategoryForm($this->getIdfromInputName($key), $val);
            }
        }

        $use_case->updateAndDelete($category_form_array, $category_delete_list);

        return redirect()->route('home');
    }

    public function getIdfromInputName(string $input_name): int
    {
        preg_match('/category_(\d+)/', $input_name, $result);
        return $result[1];
    }
}
