import React from 'react';
import { router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';

interface Props {
    count: number;
    [key: string]: unknown;
}

export default function Counter({ count }: Props) {
    const handleIncrement = () => {
        router.post(route('counter.store'), {
            action: 'increment'
        }, {
            preserveState: true,
            preserveScroll: true
        });
    };

    const handleDecrement = () => {
        router.post(route('counter.store'), {
            action: 'decrement'
        }, {
            preserveState: true,
            preserveScroll: true
        });
    };

    return (
        <div className="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 flex items-center justify-center p-4">
            <Card className="w-full max-w-md">
                <CardHeader className="text-center">
                    <CardTitle className="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Counter App
                    </CardTitle>
                </CardHeader>
                <CardContent className="space-y-6">
                    <div className="text-center">
                        <div className="text-6xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                            {count}
                        </div>
                        <p className="text-gray-600 dark:text-gray-400">
                            Current count
                        </p>
                    </div>
                    
                    <div className="flex gap-4 justify-center">
                        <Button 
                            onClick={handleDecrement}
                            variant="outline"
                            size="lg"
                            className="min-w-[120px]"
                        >
                            - Decrement
                        </Button>
                        <Button 
                            onClick={handleIncrement}
                            size="lg"
                            className="min-w-[120px]"
                        >
                            + Increment
                        </Button>
                    </div>
                    
                    <div className="text-center text-sm text-gray-500 dark:text-gray-400">
                        Counter value is persisted in PostgreSQL database
                    </div>
                </CardContent>
            </Card>
        </div>
    );
}