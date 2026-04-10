
import React, { useState } from 'react';
import { Helmet } from 'react-helmet';
import { useNavigate } from 'react-router-dom';
import { Check } from 'lucide-react';
import Header from '@/components/Header.jsx';
import Footer from '@/components/Footer.jsx';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';

const PriceCalculatorPage = () => {
  const navigate = useNavigate();
  const [step, setStep] = useState(1);
  const [selections, setSelections] = useState({
    websiteType: '',
    pageCount: '',
    features: []
  });

  const websiteTypes = [
    { value: 'Business', label: 'Business', basePrice: 1200 },
    { value: 'Portfolio', label: 'Portfolio', basePrice: 800 },
    { value: 'Blog', label: 'Blog', basePrice: 600 },
    { value: 'E-commerce', label: 'E-commerce', basePrice: 2500 }
  ];

  const pageRanges = [
    { value: '1-3', label: '1-3 pages', multiplier: 1 },
    { value: '4-8', label: '4-8 pages', multiplier: 1.5 },
    { value: '8+', label: '8+ pages', multiplier: 2.2 }
  ];

  const features = [
    { value: 'Admin Panel', label: 'Admin Panel', price: 400 },
    { value: 'Booking System', label: 'Booking System', price: 600 },
    { value: 'Online Payment', label: 'Online Payment', price: 500 },
    { value: 'Multilingual', label: 'Multilingual', price: 350 },
    { value: 'Analytics', label: 'Analytics', price: 200 }
  ];

  const calculatePrice = () => {
    const typeData = websiteTypes.find(t => t.value === selections.websiteType);
    const pageData = pageRanges.find(p => p.value === selections.pageCount);
    
    if (!typeData || !pageData) return 0;

    const basePrice = typeData.basePrice * pageData.multiplier;
    const featuresPrice = selections.features.reduce((sum, feature) => {
      const featureData = features.find(f => f.value === feature);
      return sum + (featureData?.price || 0);
    }, 0);

    return Math.round(basePrice + featuresPrice);
  };

  const handleFeatureToggle = (feature) => {
    setSelections(prev => ({
      ...prev,
      features: prev.features.includes(feature)
        ? prev.features.filter(f => f !== feature)
        : [...prev.features, feature]
    }));
  };

  const handleGetQuote = () => {
    navigate('/order', { state: { calculatorData: { ...selections, estimatedPrice: calculatePrice() } } });
  };

  const totalPrice = calculatePrice();

  return (
    <>
      <Helmet>
        <title>Price Calculator - archvadze</title>
        <meta name="description" content="Calculate the estimated cost of your website project with our interactive price calculator." />
      </Helmet>

      <div className="min-h-screen bg-white">
        <Header />

        <main className="pt-24 pb-20">
          <div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div className="text-center mb-12">
              <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style={{ letterSpacing: '-0.02em' }}>
                Price calculator
              </h1>
              <p className="text-xl text-gray-600 leading-relaxed">
                Get an instant estimate for your website project
              </p>
            </div>

            <div className="flex justify-center mb-12">
              <div className="flex items-center gap-4">
                {[1, 2, 3].map((s) => (
                  <React.Fragment key={s}>
                    <div className={`flex items-center justify-center w-10 h-10 rounded-full font-semibold ${
                      step >= s ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'
                    }`}>
                      {s}
                    </div>
                    {s < 3 && <div className={`w-16 h-1 ${step > s ? 'bg-primary' : 'bg-gray-200'}`}></div>}
                  </React.Fragment>
                ))}
              </div>
            </div>

            {step === 1 && (
              <div>
                <h2 className="text-2xl font-semibold text-gray-900 mb-6 text-center">Select website type</h2>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                  {websiteTypes.map((type) => (
                    <Card
                      key={type.value}
                      className={`cursor-pointer transition-all duration-200 hover:shadow-lg ${
                        selections.websiteType === type.value ? 'ring-2 ring-primary' : ''
                      }`}
                      onClick={() => setSelections({ ...selections, websiteType: type.value })}
                    >
                      <CardContent className="p-6">
                        <div className="flex items-center justify-between">
                          <div>
                            <h3 className="text-lg font-semibold text-gray-900">{type.label}</h3>
                            <p className="text-sm text-gray-600 mt-1">Starting at ${type.basePrice}</p>
                          </div>
                          {selections.websiteType === type.value && (
                            <Check className="text-primary" size={24} />
                          )}
                        </div>
                      </CardContent>
                    </Card>
                  ))}
                </div>
                <Button
                  onClick={() => setStep(2)}
                  disabled={!selections.websiteType}
                  className="w-full"
                >
                  Continue
                </Button>
              </div>
            )}

            {step === 2 && (
              <div>
                <h2 className="text-2xl font-semibold text-gray-900 mb-6 text-center">Select number of pages</h2>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                  {pageRanges.map((range) => (
                    <Card
                      key={range.value}
                      className={`cursor-pointer transition-all duration-200 hover:shadow-lg ${
                        selections.pageCount === range.value ? 'ring-2 ring-primary' : ''
                      }`}
                      onClick={() => setSelections({ ...selections, pageCount: range.value })}
                    >
                      <CardContent className="p-6 text-center">
                        <h3 className="text-lg font-semibold text-gray-900">{range.label}</h3>
                        {selections.pageCount === range.value && (
                          <Check className="text-primary mx-auto mt-2" size={24} />
                        )}
                      </CardContent>
                    </Card>
                  ))}
                </div>
                <div className="flex gap-3">
                  <Button variant="outline" onClick={() => setStep(1)} className="flex-1">
                    Back
                  </Button>
                  <Button
                    onClick={() => setStep(3)}
                    disabled={!selections.pageCount}
                    className="flex-1"
                  >
                    Continue
                  </Button>
                </div>
              </div>
            )}

            {step === 3 && (
              <div>
                <h2 className="text-2xl font-semibold text-gray-900 mb-6 text-center">Select features</h2>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                  {features.map((feature) => (
                    <Card
                      key={feature.value}
                      className={`cursor-pointer transition-all duration-200 hover:shadow-lg ${
                        selections.features.includes(feature.value) ? 'ring-2 ring-primary' : ''
                      }`}
                      onClick={() => handleFeatureToggle(feature.value)}
                    >
                      <CardContent className="p-6">
                        <div className="flex items-center justify-between">
                          <div>
                            <h3 className="text-lg font-semibold text-gray-900">{feature.label}</h3>
                            <p className="text-sm text-gray-600 mt-1">+${feature.price}</p>
                          </div>
                          {selections.features.includes(feature.value) && (
                            <Check className="text-primary" size={24} />
                          )}
                        </div>
                      </CardContent>
                    </Card>
                  ))}
                </div>

                <Card className="mb-8 bg-gray-50">
                  <CardContent className="p-6">
                    <h3 className="text-xl font-semibold text-gray-900 mb-4">Price breakdown</h3>
                    <div className="space-y-2 mb-4">
                      <div className="flex justify-between text-gray-700">
                        <span>Base price ({selections.websiteType})</span>
                        <span>${websiteTypes.find(t => t.value === selections.websiteType)?.basePrice || 0}</span>
                      </div>
                      <div className="flex justify-between text-gray-700">
                        <span>Pages ({selections.pageCount})</span>
                        <span>×{pageRanges.find(p => p.value === selections.pageCount)?.multiplier || 1}</span>
                      </div>
                      {selections.features.map(feature => {
                        const featureData = features.find(f => f.value === feature);
                        return (
                          <div key={feature} className="flex justify-between text-gray-700">
                            <span>{feature}</span>
                            <span>+${featureData?.price || 0}</span>
                          </div>
                        );
                      })}
                    </div>
                    <div className="pt-4 border-t border-gray-300">
                      <div className="flex justify-between items-center">
                        <span className="text-2xl font-bold text-gray-900">Total estimate</span>
                        <span className="text-3xl font-bold text-primary">${totalPrice}</span>
                      </div>
                    </div>
                  </CardContent>
                </Card>

                <div className="flex gap-3">
                  <Button variant="outline" onClick={() => setStep(2)} className="flex-1">
                    Back
                  </Button>
                  <Button onClick={handleGetQuote} className="flex-1">
                    Get Quote
                  </Button>
                </div>
              </div>
            )}
          </div>
        </main>

        <Footer />
      </div>
    </>
  );
};

export default PriceCalculatorPage;
