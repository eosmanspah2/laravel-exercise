import { Variant } from "../types/variant";

export function VariantsTable({ variants }: { variants: Variant[] }) {
  return (
    <div className="my-4">
      <h3 className="text-lg font-semibold mb-2">Variants:</h3>
      <div className="overflow-x-auto">
        <table className="w-full table-auto">
          <thead>
            <tr className="bg-gray-200">
              <TableHeader>Name</TableHeader>
              <TableHeader>Value</TableHeader>
              <TableHeader>Price</TableHeader>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-300">
            {variants?.map((variant) => (
              <TableRow key={variant.id}>
                <TableCell>{variant.name}</TableCell>
                <TableCell>{variant.value}</TableCell>
                <TableCell>{variant.price}</TableCell>
              </TableRow>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}

function TableHeader({ children }: { children: React.ReactNode }) {
  return <th className="px-4 py-2">{children}</th>;
}

function TableRow({ children }: { children: React.ReactNode }) {
  return <tr className="hover:bg-gray-100">{children}</tr>;
}

function TableCell({ children }: { children: React.ReactNode }) {
  return <td className="px-4 py-2">{children}</td>;
}
