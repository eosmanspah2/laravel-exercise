export async function getProducts(includeVariant: boolean) {
  const url = `${process.env.NEXT_PUBLIC_DATA_URL}/api/product${
    includeVariant ? "?includeVariants=true" : ""
  }`;

  return await fetch(url, {
    headers: {
      Authorization: `Bearer ${process.env.NEXT_PUBLIC_AUTH}`,
    },
  });
}

export async function getProductById(id: number, includeVariant = false) {
  const url = `${process.env.NEXT_PUBLIC_DATA_URL}/api/product/${id}${
    includeVariant ? "?includeVariants=true" : ""
  }`;
  return await fetch(url, {
    headers: {
      Authorization: `Bearer ${process.env.NEXT_PUBLIC_AUTH}`,
    },
  });
}


