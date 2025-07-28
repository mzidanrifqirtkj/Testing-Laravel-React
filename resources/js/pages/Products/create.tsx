import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Products',
        href: '/products/create',
    },
];

export default function index() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Products" />
            <div className="w-8/12 p-4">
                <form action="">
                    <div>
                        <Label>Product Name</Label>
                        <Input placeholder="Enter product name"></Input>
                    </div>
                    <div>
                        <Label>Product Price</Label>
                        <Input placeholder="Enter product price"></Input>
                    </div>
                    <div>
                        <Label>Product Description</Label>
                        <Input placeholder="Enter product description"></Input>
                    </div>
                </form>
            </div>
        </AppLayout>
    );
}
