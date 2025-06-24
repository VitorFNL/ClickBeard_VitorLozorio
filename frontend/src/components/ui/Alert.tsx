import React from 'react';
import { AlertTriangle, CheckCircle, Info, X } from 'lucide-react';
import { cn } from '../../lib/utils';

interface AlertProps extends React.HTMLAttributes<HTMLDivElement> {
  variant?: 'default' | 'destructive' | 'success' | 'warning';
  closeable?: boolean;
  onClose?: () => void;
}

const Alert = React.forwardRef<HTMLDivElement, AlertProps>(
  ({ className, variant = 'default', closeable = false, onClose, children, ...props }, ref) => {
    const icons = {
      default: <Info className="h-4 w-4" />,
      destructive: <AlertTriangle className="h-4 w-4" />,
      success: <CheckCircle className="h-4 w-4" />,
      warning: <AlertTriangle className="h-4 w-4" />,
    };

    return (
      <div
        ref={ref}
        role="alert"        className={cn(
          'relative w-full rounded-lg border p-4 [&>svg~*]:pl-7 [&>svg+div]:translate-y-[-3px] [&>svg]:absolute [&>svg]:left-4 [&>svg]:top-4',
          {
            'bg-white text-gray-900 border-gray-200': variant === 'default',
            'border-red-200 text-red-700 bg-red-50 [&>svg]:text-red-600': variant === 'destructive',
            'border-green-200 text-green-700 bg-green-50 [&>svg]:text-green-600': variant === 'success',
            'border-yellow-200 text-yellow-700 bg-yellow-50 [&>svg]:text-yellow-600': variant === 'warning',
          },
          className
        )}
        {...props}
      >
        {icons[variant]}
        <div className="flex-1">
          {children}
        </div>
        {closeable && (
          <button
            onClick={onClose}
            className="absolute right-2 top-2 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
          >
            <X className="h-4 w-4" />
            <span className="sr-only">Fechar</span>
          </button>
        )}
      </div>
    );
  }
);
Alert.displayName = 'Alert';

const AlertTitle = React.forwardRef<HTMLParagraphElement, React.HTMLAttributes<HTMLHeadingElement>>(
  ({ className, ...props }, ref) => (
    <h5
      ref={ref}
      className={cn('mb-1 font-medium leading-none tracking-tight', className)}
      {...props}
    />
  )
);
AlertTitle.displayName = 'AlertTitle';

const AlertDescription = React.forwardRef<HTMLParagraphElement, React.HTMLAttributes<HTMLParagraphElement>>(
  ({ className, ...props }, ref) => (
    <div
      ref={ref}
      className={cn('text-sm [&_p]:leading-relaxed', className)}
      {...props}
    />
  )
);
AlertDescription.displayName = 'AlertDescription';

export { Alert, AlertTitle, AlertDescription };
