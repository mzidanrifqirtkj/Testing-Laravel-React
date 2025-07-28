import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Products',
        href: '/products/create',
    },
];

export default function index() {
    const { data, setData, post, processing, errors } = useForm({
        productName: '',
        productPrice: '',
        productDescription: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('products.store', {
            onSuccess: () => {
                // Optionally redirect or show a success message
            },
            onError: (errors) => {
                // Handle errors, e.g., show error messages
                console.error(errors);
            },
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Products" />
            <div className="w-8/12 p-4">
                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <Label>Product Name</Label>
                        <Input
                            placeholder="Enter product name"
                            value={data.productName}
                            onChange={(e) => setData('productName', e.target.value)}
                        ></Input>
                    </div>
                    <div>
                        <Label>Product Price</Label>
                        <Input
                            placeholder="Enter product price"
                            value={data.productPrice}
                            onChange={(e) => setData('productPrice', e.target.value)}
                        ></Input>
                    </div>
                    <div>
                        <Label>Product Description</Label>
                        <Textarea
                            placeholder="Enter product description"
                            value={data.productDescription}
                            onChange={(e) => setData('productDescription', e.target.value)}
                        ></Textarea>
                    </div>
                    <Button type="submit">Create Product</Button>
                </form>
            </div>
        </AppLayout>
    );
}
