<?php

namespace PixelWrap\Laravel\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use PixelWrap\Laravel\PixelWrapRenderer;

class FileController extends PixelController
{
    protected $class = Model::class;
    protected $filename;
    protected $file;
    protected $perPage = 15;
    public string $primaryKey = "id";
    public $relationships = [];

    public function __construct(PixelWrapRenderer $pixel)
    {
        parent::__construct($pixel);
        if (!isset($this->filename)) {
            $this->filename = class_basename($this->class);
        }
        if (!isset($this->file)) {
            $this->file = Str::lower($this->filename);
        }
        if (!isset($this->resources)) {
            $this->resources = $this->file;
        }
    }

    public function index()
    {
        $query = $this->class::query()->with($this->relationships)->latest($this->primaryKey);
        $details = [];
        if (method_exists($this, "listingQuery")) {
            $query = $this->listingQuery($query);
        }
        $files = $query->paginate($this->perPage);
        if (method_exists($this, "showDetails")) {
            $details = $this->showDetails();
        }
        return $this->render("listing", [...$details, $this->file => $files]);
    }

    public function create()
    {
        $data = [];
        if (method_exists($this, "createDetails")) {
            $data = $this->createDetails();
        }
        return $this->render("create", $data);
    }
    protected function getFile(Request $request)
    {
        $id = $request->route(Str::slug($this->file, "_"));
        return $this->class::query()->where($this->primaryKey, $id)->firstOrFail();
    }
    public function store(Request $request)
    {
        if (method_exists($this, "storeDetails")) {
            $details = $this->storeDetails($request);
        } else {
            $details = [];
        }
        $file = $this->class::query()->create($request->merge($details)->all());
        return $this->route("edit", $file)->with("success", "$this->filename created successfully");
    }

    public function edit(Request $request)
    {
        $file = $this->getFile($request);
        if (method_exists($this, "editDetails")) {
            $details = [...$this->editDetails($file), ...$file->toArray()];
        } else {
            $details = $file->toArray();
        }
        return $this->render("edit", $details);
    }

    public function show(Request $request)
    {
        $file = $this->getFile($request);
        $details = $file->toArray();
        if (method_exists($this, "getDetails")) {
            $details = [...$this->getDetails($file), ...$file->toArray()];
        }
        return $this->render("show", $details);
    }

    public function update(Request $request)
    {
        $file = $this->getFile($request);
        if (method_exists($this, "performUpdate")) {
            return $this->performUpdate($file);
        } else {
            $file->update($request->all());
        }
        return $this->route("edit", $file)->with("success", "$this->filename updated successfully");
    }

    public function destroy(Request $request)
    {
        $file = $this->getFile($request);
        $file->delete();
        return $this->route("index")->with("success", "$this->filename deleted successfully");
    }
}
