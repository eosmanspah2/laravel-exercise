import { Product } from "@/lib/types/product";
import { Variant } from "@/lib/types/variant";
import { getProductById } from "@/lib/apis/customBackend";
import { useEffect, useState } from "react";
import { ProductDetails } from "@/lib/components/productDetails";
import { VariantsTable } from "@/lib/components/variants";
export default function ProductDetailPage({ params }) {
  const [product, setProduct] = useState<Product>(null);
  const [variants, setVariants] = useState<Variant[]>([]);

  useEffect(() => {
    async function fetchData() {
      const response = await getProductById(params.id);
      const product = await response.json();
      setProduct(product.data);
    }
    fetchData();
  }, []);

  return (
    <>
      <ProductDetails product={product} />
      <VariantsTable variants={product.variants} />
    </>
  );
}
