
import React from 'react';
import { Helmet } from 'react-helmet';
import { motion } from 'framer-motion';
import { Code, Palette, ShoppingCart, TrendingUp, Wrench, Zap } from 'lucide-react';
import Header from '@/components/Header.jsx';
import Footer from '@/components/Footer.jsx';

const ServicesPage = () => {
  const services = [
    {
      icon: Palette,
      title: 'Web Design',
      description: 'Create stunning, user-friendly interfaces that captivate your audience and drive engagement.',
      benefits: ['Custom UI/UX design', 'Responsive layouts', 'Brand identity integration', 'Wireframing & prototyping']
    },
    {
      icon: Code,
      title: 'Web Development',
      description: 'Build robust, scalable websites with modern technologies and best practices.',
      benefits: ['React & Next.js development', 'API integration', 'Database architecture', 'Performance optimization']
    },
    {
      icon: ShoppingCart,
      title: 'E-commerce Solutions',
      description: 'Launch your online store with secure payment processing and inventory management.',
      benefits: ['Shopping cart integration', 'Payment gateway setup', 'Product management', 'Order tracking']
    },
    {
      icon: TrendingUp,
      title: 'SEO Optimization',
      description: 'Improve your search rankings and drive organic traffic to your website.',
      benefits: ['Keyword research', 'On-page optimization', 'Technical SEO', 'Analytics setup']
    },
    {
      icon: Wrench,
      title: 'Maintenance & Support',
      description: 'Keep your website running smoothly with ongoing updates and technical support.',
      benefits: ['Regular updates', 'Security monitoring', 'Bug fixes', '24/7 support']
    }
  ];

  return (
    <>
      <Helmet>
        <title>Services - archvadze</title>
        <meta name="description" content="Explore our comprehensive web development services including design, development, e-commerce, SEO, and maintenance." />
      </Helmet>

      <div className="min-h-screen bg-white">
        <Header />

        <main className="pt-24 pb-20">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.5 }}
              className="text-center mb-16"
            >
              <h1 className="text-4xl md:text-5xl font-bold text-gray-900 mb-4" style={{ letterSpacing: '-0.02em' }}>
                Our services
              </h1>
              <p className="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Comprehensive solutions to bring your digital vision to life
              </p>
            </motion.div>

            <div className="space-y-24">
              {services.map((service, index) => (
                <motion.div
                  key={service.title}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.5, delay: index * 0.1 }}
                  className={`grid grid-cols-1 md:grid-cols-2 gap-12 items-center ${
                    index % 2 === 1 ? 'md:flex-row-reverse' : ''
                  }`}
                >
                  <div className={index % 2 === 1 ? 'md:order-2' : ''}>
                    <div className="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-primary/10 text-primary mb-6">
                      <service.icon size={32} />
                    </div>
                    <h2 className="text-3xl font-semibold text-gray-900 mb-4">{service.title}</h2>
                    <p className="text-lg text-gray-600 leading-relaxed mb-6">{service.description}</p>
                    <ul className="space-y-3">
                      {service.benefits.map((benefit) => (
                        <li key={benefit} className="flex items-start gap-3">
                          <Zap size={20} className="text-primary mt-0.5 flex-shrink-0" />
                          <span className="text-gray-700">{benefit}</span>
                        </li>
                      ))}
                    </ul>
                  </div>
                  <div className={index % 2 === 1 ? 'md:order-1' : ''}>
                    <div className="aspect-video bg-gradient-to-br from-primary/20 to-primary/5 rounded-2xl"></div>
                  </div>
                </motion.div>
              ))}
            </div>
          </div>
        </main>

        <Footer />
      </div>
    </>
  );
};

export default ServicesPage;
