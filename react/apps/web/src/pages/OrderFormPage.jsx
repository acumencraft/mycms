
import React, { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet';
import { useNavigate, useLocation } from 'react-router-dom';
import { useAuth } from '@/contexts/AuthContext.jsx';
import pb from '@/lib/pocketbaseClient';
import Header from '@/components/Header.jsx';
import Footer from '@/components/Footer.jsx';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Checkbox } from '@/components/ui/checkbox';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { AlertCircle } from 'lucide-react';

const OrderFormPage = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const { currentUser } = useAuth();
  const calculatorData = location.state?.calculatorData;

  const [formData, setFormData] = useState({
    name: currentUser?.name || '',
    email: currentUser?.email || '',
    phone: '',
    domain: '',
    website_type: calculatorData?.websiteType || '',
    features: calculatorData?.features || [],
    description: '',
    price_estimate: calculatorData?.estimatedPrice || 0
  });

  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);

  const websiteTypes = ['Business', 'Portfolio', 'Blog', 'E-commerce'];
  const availableFeatures = [
    'Contact Form',
    'Blog',
    'Gallery',
    'E-commerce',
    'Analytics',
    'SEO',
    'Mobile Responsive',
    'Dark Mode'
  ];

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleFeatureToggle = (feature) => {
    setFormData(prev => ({
      ...prev,
      features: prev.features.includes(feature)
        ? prev.features.filter(f => f !== feature)
        : [...prev.features, feature]
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    if (!currentUser) {
      setError('Please login to submit an order');
      return;
    }

    setLoading(true);

    try {
      const orderData = {
        user_id: currentUser.id,
        name: formData.name,
        email: formData.email,
        phone: formData.phone,
        domain: formData.domain,
        website_type: formData.website_type,
        features: formData.features,
        description: formData.description,
        price_estimate: formData.price_estimate,
        status: 'pending'
      };

      await pb.collection('orders').create(orderData, { $autoCancel: false });
      navigate('/dashboard');
    } catch (err) {
      setError('Failed to submit order. Please try again.');
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <Helmet>
        <title>Order Form - archvadze</title>
        <meta name="description" content="Submit your website project order and get started with archvadze." />
      </Helmet>

      <div className="min-h-screen bg-white">
        <Header />

        <main className="pt-24 pb-20">
          <div className="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style={{ letterSpacing: '-0.02em' }}>
                Start your project
              </h1>
              <p className="text-xl text-gray-600 leading-relaxed">
                Fill out the form below and we'll get back to you shortly
              </p>
            </div>

            <form onSubmit={handleSubmit} className="space-y-6">
              {error && (
                <Alert variant="destructive">
                  <AlertCircle className="h-4 w-4" />
                  <AlertDescription>{error}</AlertDescription>
                </Alert>
              )}

              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="space-y-2">
                  <Label htmlFor="name">Full Name *</Label>
                  <Input
                    id="name"
                    name="name"
                    value={formData.name}
                    onChange={handleChange}
                    required
                    className="text-gray-900"
                  />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="email">Email *</Label>
                  <Input
                    id="email"
                    name="email"
                    type="email"
                    value={formData.email}
                    onChange={handleChange}
                    required
                    className="text-gray-900"
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div className="space-y-2">
                  <Label htmlFor="phone">Phone</Label>
                  <Input
                    id="phone"
                    name="phone"
                    type="tel"
                    value={formData.phone}
                    onChange={handleChange}
                    className="text-gray-900"
                  />
                </div>

                <div className="space-y-2">
                  <Label htmlFor="domain">Domain Name *</Label>
                  <Input
                    id="domain"
                    name="domain"
                    value={formData.domain}
                    onChange={handleChange}
                    placeholder="example.com"
                    required
                    className="text-gray-900"
                  />
                </div>
              </div>

              <div className="space-y-2">
                <Label htmlFor="website_type">Website Type *</Label>
                <Select
                  value={formData.website_type}
                  onValueChange={(value) => setFormData({ ...formData, website_type: value })}
                >
                  <SelectTrigger className="text-gray-900">
                    <SelectValue placeholder="Select website type" />
                  </SelectTrigger>
                  <SelectContent>
                    {websiteTypes.map((type) => (
                      <SelectItem key={type} value={type}>{type}</SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>

              <div className="space-y-3">
                <Label>Features</Label>
                <div className="grid grid-cols-2 gap-3">
                  {availableFeatures.map((feature) => (
                    <div key={feature} className="flex items-center space-x-2">
                      <Checkbox
                        id={feature}
                        checked={formData.features.includes(feature)}
                        onCheckedChange={() => handleFeatureToggle(feature)}
                      />
                      <label
                        htmlFor={feature}
                        className="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer"
                      >
                        {feature}
                      </label>
                    </div>
                  ))}
                </div>
              </div>

              <div className="space-y-2">
                <Label htmlFor="description">Project Description</Label>
                <Textarea
                  id="description"
                  name="description"
                  value={formData.description}
                  onChange={handleChange}
                  rows={5}
                  placeholder="Tell us about your project requirements..."
                  className="text-gray-900"
                />
              </div>

              {calculatorData && (
                <div className="bg-gray-50 p-4 rounded-lg">
                  <p className="text-sm text-gray-600">Estimated Price</p>
                  <p className="text-2xl font-bold text-primary">${formData.price_estimate}</p>
                </div>
              )}

              <Button type="submit" className="w-full" disabled={loading}>
                {loading ? 'Submitting...' : 'Submit Order'}
              </Button>
            </form>
          </div>
        </main>

        <Footer />
      </div>
    </>
  );
};

export default OrderFormPage;
