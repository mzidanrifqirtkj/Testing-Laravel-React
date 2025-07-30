import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { useEffect } from 'react';
import { toast } from 'sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];

interface Product {
    id: number;
    name: string;
    price: number;
    description: string;
}

interface PageProps {
    flash: {
        message?: string;
    };
    products: Product[];
}

export default function index() {
    const { flash, products } = usePage().props as PageProps;

    useEffect(() => {
        if (flash.message) {
            toast(flash.message);
        }
    }, [flash]);

    const { processing, delete: destroy } = useForm();

    const handleDelete = (id: number, name: string) => {
        if (confirm(`Are you sure you want to delete ${name}?`)) {
            destroy(route('products.destroy', id));
        }
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Products" />
            <div className="m-4">
                <Link href={route('products.create')} className="btn btn-primary">
                    <Button>Create Product</Button>
                </Link>
            </div>
            {products.length > 0 && (
                <div className="m-4">
                    <Table>
                        <TableCaption>List Products</TableCaption>
                        <TableHeader>
                            <TableRow>
                                <TableHead className="w-[100px]">ID</TableHead>
                                <TableHead>Name</TableHead>
                                <TableHead>Price</TableHead>
                                <TableHead>Description</TableHead>
                                <TableHead className="text-center">Action</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            {products.map((product) => (
                                //  key={product.id}
                                <TableRow>
                                    <TableCell className="font-medium">{product.id}</TableCell>
                                    <TableCell>{product.name}</TableCell>
                                    <TableCell>{product.price.toFixed(2)}</TableCell>
                                    <TableCell>{product.description}</TableCell>
                                    <TableCell className="text-center">
                                        <Link href={route('products.edit', product.id)} className="btn btn-secondary">
                                            Edit
                                        </Link>
                                        <Button
                                            disabled={processing}
                                            onClick={() => handleDelete(product.id, product.name)}
                                            className="btn btn-danger ml-2"
                                        >
                                            Delete
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </div>
            )}
        </AppLayout>
    );
}
