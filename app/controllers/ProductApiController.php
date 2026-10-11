<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductApiController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->call->library('api');
        $this->call->model('ProductModel');
    }

    private function authenticate()
    {
        $this->api->require_jwt();
    }

    private function product_data(array $input)
    {
        $product_name = $input['product_name'] ?? '';
        $description = $input['description'] ?? '';
        $price = $input['price'] ?? null;
        $quantity = filter_var(
            $input['quantity'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (!is_string($product_name) || trim($product_name) === '') {
            $this->api->respond_error('Product name is required.', 400);
        }

        if ($description === null) {
            $description = '';
        }

        if (!is_string($description)) {
            $this->api->respond_error('Description must be text.', 400);
        }

        if (
            !is_numeric($price) ||
            !is_finite((float) $price) ||
            (float) $price < 0 ||
            (float) $price > 99999999.99
        ) {
            $this->api->respond_error(
                'Price must be between 0 and 99999999.99.',
                400
            );
        }

        if ($quantity === false || $quantity < 0 || $quantity > 4294967295) {
            $this->api->respond_error(
                'Quantity must be a non-negative whole number.',
                400
            );
        }

        return [
            'product_name' => trim($product_name),
            'description' => trim($description),
            'price' => (float) $price,
            'quantity' => $quantity
        ];
    }

    public function index()
    {
        $this->api->require_method('GET');
        $this->authenticate();

        $products = $this->ProductModel->all();

        $this->api->respond([
            'status' => true,
            'message' => 'Products retrieved successfully.',
            'data' => $products
        ]);
    }

    public function show($id)
    {
        $this->api->require_method('GET');
        $this->authenticate();

        $product = $this->ProductModel->find($id);

        if (!$product) {
            $this->api->respond_error('Product not found.', 404);
            return;
        }

        $this->api->respond([
            'status' => true,
            'message' => 'Product retrieved successfully.',
            'data' => $product
        ]);
    }

    public function store()
    {
        $this->api->require_method('POST');
        $this->authenticate();

        $data = $this->product_data($this->api->body());
        $id = $this->ProductModel->insert($data);

        if (!$id) {
            $this->api->respond_error('Product could not be created.', 500);
        }

        $product = $this->ProductModel->find($id);

        $this->api->respond([
            'status' => true,
            'message' => 'Product created successfully.',
            'data' => $product
        ], 201);
    }

    public function update($id)
    {
        $this->api->require_method('PUT');
        $this->authenticate();

        $product = $this->ProductModel->find($id);

        if (!$product) {
            $this->api->respond_error(
                'Product not found.',
                404
            );

            return;
        }

        $data = $this->product_data($this->api->body());

        $this->ProductModel->update($id, $data);
        $product = $this->ProductModel->find($id);

        $this->api->respond([
            'status' => true,
            'message' => 'Product updated successfully.',
            'data' => $product
        ]);
    }

    public function delete($id)
    {
        $this->api->require_method('DELETE');
        $this->authenticate();

        $product = $this->ProductModel->find($id);

        if (!$product) {
            $this->api->respond_error(
                'Product not found.',
                404
            );

            return;
        }

        $this->ProductModel->delete($id);

        $this->api->respond([
            'status' => true,
            'message' => 'Product deleted successfully.',
            'data' => null
        ]);
    }
}
?>