<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Entities\CategoryEntity;

class CategoryController extends BaseController
{
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $keyword = esc($this->request->getVar("q"));
        $validation = service("validation");
        $categories = $this->categoryModel->search($keyword);

        $data = [
            "title"         => lang("Category.title.index"),
            "keyword"       => $keyword,
            "validation"    => $validation->getErrors(),
            "categories"    => $categories->paginate(10, "categories"),
            "pager"         => $categories->pager->links("categories", "default"),
        ];

        return view("categories/index", $data);
    }

    public function create()
    {
        $inputs = esc($this->request->getPost());

        if (!$this->validate("createCategory")) {
            return redirect()->to("/categories")->withInput()->with("validationErrorCreate", true);
        }

        $category = new CategoryEntity();
        $category->name = $inputs["name"];

        // Saving new category
        $this->categoryModel->save($category);

        return redirect()->to("/categories")->with("successMessage", lang("Category.message.success.create"));
    }

    public function edit(int $id)
    {
        $category = $this->categoryModel->find($id);

        if (empty($category)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Category.message.error.categoryNotFound"));
        }

        return json_encode($category);
    }

    public function update(int $id)
    {
        $category = $this->categoryModel->find($id);

        if (empty($category)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Category.message.error.categoryNotFound"));
        }

        $inputs = esc($this->request->getPost());

        if (!$this->validate("updateCategory")) {
            return redirect()->to("/categories")->with("validationErrorUpdate", $id)->withInput();
        }

        $category->name = $inputs["name"];

        $this->categoryModel->save($category);

        return redirect()->to("/categories")->with("successMessage", lang("Category.message.success.update"));
    }

    public function delete(int $id)
    {
        $this->categoryModel->where("id", $id)->delete();
        return redirect()->to("/categories")->with("successMessage", lang("Category.message.success.delete"));
    }
}
