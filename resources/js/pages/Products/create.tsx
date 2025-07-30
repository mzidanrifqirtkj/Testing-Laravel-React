import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/react';
import { CircleAlert } from 'lucide-react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Create Products',
        href: '/products/create',
    },
];

export default function index() {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        price: '',
        description: '',
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('products.store'));
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Create Products" />
            <div className="w-8/12 p-4">
                <form onSubmit={handleSubmit} className="space-y-4">
                    {/* Display Error */}

                    {Object.keys(errors).length > 0 && (
                        <Alert>
                            <CircleAlert className="h-4 w-4" />
                            <AlertTitle>Alert!</AlertTitle>
                            <AlertDescription>
                                <ul>
                                    {Object.entries(errors).map(([key, value]) => (
                                        <li key={key} className="text-red-500">
                                            {value}
                                        </li>
                                    ))}
                                </ul>
                            </AlertDescription>
                        </Alert>
                    )}

                    {/* Input Fields */}
                    <div>
                        <Label>Product Name</Label>
                        <Input placeholder="Enter product name" value={data.name} onChange={(e) => setData('name', e.target.value)}></Input>
                    </div>
                    <div>
                        <Label>Product Price</Label>
                        <Input placeholder="Enter product price" value={data.price} onChange={(e) => setData('price', e.target.value)}></Input>
                    </div>
                    <div>
                        <Label>Product Description</Label>
                        <Textarea
                            placeholder="Enter product description"
                            value={data.description}
                            onChange={(e) => setData('description', e.target.value)}
                        ></Textarea>
                    </div>
                    <Button type="submit">Create Product</Button>
                </form>
            </div>
        </AppLayout>
    );
}
