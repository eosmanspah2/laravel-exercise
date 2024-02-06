import React, { useEffect, useState } from "react";
import Link from "next/link";
import { getProducts } from "../../lib/apis/customBackend";
import { Product } from "../../lib/types/product";

const ProductListingPage = () => {
  const [products, setProducts] = useState<Product[]>();

  useEffect(() => {
    async function fetchData() {
      const response = await getProducts(false);
      const products = await response.json();
      setProducts(products.data);
    }
    fetchData();
  }, []);

  return (
    <div className="container mx-auto px-4 py-8">
      <table className="w-full table-auto">
        <thead>
          <tr>
            <TableHeader>ID</TableHeader>
            <TableHeader>Name</TableHeader>
            <TableHeader>Description</TableHeader>
            <TableHeader>Actions</TableHeader>
          </tr>
        </thead>
        <tbody>
          {products?.map((product: Product) => (
            <TableRow key={product.id}>
              <TableCell>{product.id}</TableCell>
              <TableCell>{product.name}</TableCell>
              <TableCell>{product.description}</TableCell>
              <TableCell>
                <Link href={`/products/${product.id}`}>
                  <a className="text-blue-500 hover:underline">Edit</a>
                </Link>
              </TableCell>
            </TableRow>
          ))}
        </tbody>
      </table>
    </div>
  );
};

const TableHeader = ({ children }) => <th className="px-4 py-2">{children}</th>;

const TableCell = ({ children }) => <td className="px-4 py-2">{children}</td>;

const TableRow = ({ children }) => <tr className="border-t">{children}</tr>;

export default ProductListingPage;
