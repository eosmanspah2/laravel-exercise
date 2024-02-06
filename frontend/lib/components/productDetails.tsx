import { Product } from "../types/product";

export function ProductDetails({ product }: { product: Product }) {
  return (
    <div className="bg-gray-100 p-4 rounded-lg">
      <h5 className="text-lg font-semibold mb-2">Product Information</h5>
      {product && (
        <div className="grid grid-cols-2 gap-y-2">
          <Detail label="ID" value={product.id} />
          <Detail label="Name" value={product.name} />
          <Detail label="Status" value={product.status} />
          <Detail label="Description" value={product.description} />
        </div>
      )}
    </div>
  );
}

function Detail({ label, value }: { label: string; value: string | number}) {
  return (
    <>
      <p className="text-sm font-semibold">{label}:</p>
      <p className="text-sm">{value}</p>
    </>
  );
}
