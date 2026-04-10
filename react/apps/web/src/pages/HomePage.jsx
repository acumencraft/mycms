
import React, { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import pb from '@/lib/pocketbaseClient';
import Header from '@/components/Header.jsx';
import Footer from '@/components/Footer.jsx';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Code, Palette, ShoppingCart, TrendingUp, Wrench, ArrowRight, Quote } from 'lucide-react';

const HomePage = () => {
  const [portfolioItems, setPortfolioItems] = useState([]);

  useEffect(() => {
    const fetchPortfolio = async () => {
      try {
        const records = await pb.collection('portfolio_items').getFullList({
          sort: '-created',
          $autoCancel: false
        });
        setPortfolioItems(records.slice(0, 6));
      } catch (error) {
        console.error('Failed to fetch portfolio:', error);
      }
    };

    fetchPortfolio();
  }, []);

  const services = [
    {
      icon: Palette,
      title: 'Web Design',
      description: 'Create stunning, user-friendly interfaces that captivate your audience and drive engagement.'
    },
    {
      icon: Code,
      title: 'Web Development',
      description: 'Build robust, scalable websites with modern technologies and best practices.'
    },
    {
      icon: ShoppingCart,
      title: 'E-commerce',
      description: 'Launch your online store with secure payment processing and inventory management.'
    },
    {
      icon: TrendingUp,
      title: 'SEO Optimization',
      description: 'Improve your search rankings and drive organic traffic to your website.'
    },
    {
      icon: Wrench,
      title: 'Maintenance & Support',
      description: 'Keep your website running smoothly with ongoing updates and technical support.'
    }
  ];

  const portfolioImages = [
    'https://images.unsplash.com/photo-1687006067259-6de13ca3875e',
    'https://images.unsplash.com/photo-1524221629551-6dd14def5ffd',
    'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8',
    'https://images.unsplash.com/photo-1688760871131-29afc15029ec',
    'https://images.unsplash.com/photo-1678690832311-bb6e361989ca',
    'https://images.unsplash.com/photo-1518773553398-650c184e0bb3'
  ];

  const testimonials = [
    {
      name: 'Lucia Torres',
      role: 'CEO, Coastal Roasters',
      image: 'https://images.unsplash.com/photo-1544212408-c711b7c19b92',
      text: 'Working with archvadze transformed our online presence. The team delivered a beautiful, functional website that exceeded our expectations.'
    },
    {
      name: 'Raj Patel',
      role: 'Founder, Meridian Labs',
      image: 'https://images.unsplash.com/photo-1688484185622-3cd9878ebe73',
      text: 'Professional, responsive, and incredibly talented. They took our vision and turned it into reality with precision and care.'
    },
    {
      name: 'Kwame Asante',
      role: 'Director, Elm & Oak',
      image: 'https://images.unsplash.com/photo-1493882552576-fce827c6161e',
      text: 'The attention to detail and commitment to quality is outstanding. Our e-commerce platform has driven significant growth for our business.'
    },
    {
      name: 'Anika Bergström',
      role: 'Marketing Lead, Nordic Design Co',
      image: 'https://images.unsplash.com/photo-1659353219716-699803846194',
      text: 'From concept to launch, the process was seamless. The team understood our needs and delivered a website that truly represents our brand.'
    }
  ];

  return (
    <>
      <Helmet>
        <title>archvadze - Build Your Digital Presence</title>
        <meta name="description" content="Professional web design and development services. Create stunning websites that drive results for your business." />
      </Helmet>

      <div className="min-h-screen bg-white">
        <Header />

        <section className="relative min-h-screen flex items-center justify-center overflow-hidden">
          <div className="absolute inset-0 z-0">
            <img
              src="https://images.unsplash.com/photo-1687042277317-7f0738d801bd"
              alt="Modern workspace with laptop and design tools"
              className="w-full h-full object-cover"
            />
            <div className="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-gray-900/70"></div>
          </div>

          <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6 }}
            >
              <h1 className="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-tight" style={{ letterSpacing: '-0.02em' }}>
                Build your digital presence
              </h1>
              <p className="text-xl md:text-2xl text-gray-200 mb-8 max-w-3xl mx-auto leading-relaxed">
                Professional web design and development services that transform your vision into reality
              </p>
              <Button asChild size="lg" className="text-lg px-8 py-6">
                <Link to="/order">
                  Get Started <ArrowRight className="ml-2" size={20} />
                </Link>
              </Button>
            </motion.div>
          </div>
        </section>

        <section className="py-24 bg-white">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5 }}
              className="text-center mb-16"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4" style={{ letterSpacing: '-0.02em' }}>
                Our services
              </h2>
              <p className="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Comprehensive solutions to bring your digital vision to life
              </p>
            </motion.div>

            <div className="space-y-16">
              {services.map((service, index) => (
                <motion.div
                  key={service.title}
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.5, delay: index * 0.1 }}
                  className={`grid grid-cols-1 md:grid-cols-2 gap-12 items-center ${
                    index % 2 === 1 ? 'md:flex-row-reverse' : ''
                  }`}
                >
                  <div className={index % 2 === 1 ? 'md:order-2' : ''}>
                    <div className="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-primary/10 text-primary mb-4">
                      <service.icon size={28} />
                    </div>
                    <h3 className="text-2xl font-semibold text-gray-900 mb-3">{service.title}</h3>
                    <p className="text-lg text-gray-600 leading-relaxed">{service.description}</p>
                  </div>
                  <div className={index % 2 === 1 ? 'md:order-1' : ''}>
                    <div className="aspect-video bg-gradient-to-br from-primary/20 to-primary/5 rounded-2xl"></div>
                  </div>
                </motion.div>
              ))}
            </div>
          </div>
        </section>

        <section className="py-24 bg-gray-50">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5 }}
              className="text-center mb-16"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4" style={{ letterSpacing: '-0.02em' }}>
                Our portfolio
              </h2>
              <p className="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Showcasing our latest projects and digital solutions
              </p>
            </motion.div>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
              {portfolioItems.map((item, index) => (
                <motion.div
                  key={item.id}
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.5, delay: index * 0.1 }}
                >
                  <Card className="overflow-hidden hover:shadow-lg transition-shadow">
                    <div className="aspect-video overflow-hidden">
                      <img
                        src={portfolioImages[index] || item.image_url}
                        alt={item.project_title}
                        className="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                      />
                    </div>
                    <CardContent className="p-6">
                      <h3 className="text-xl font-semibold text-gray-900 mb-2">{item.project_title}</h3>
                      <p className="text-gray-600 mb-4 leading-relaxed">{item.description}</p>
                      <div className="flex flex-wrap gap-2">
                        {item.technologies?.slice(0, 3).map((tech) => (
                          <Badge key={tech} variant="secondary" className="text-xs">
                            {tech}
                          </Badge>
                        ))}
                      </div>
                    </CardContent>
                  </Card>
                </motion.div>
              ))}
            </div>

            <div className="text-center mt-12">
              <Button asChild variant="outline" size="lg">
                <Link to="/portfolio">View All Projects</Link>
              </Button>
            </div>
          </div>
        </section>

        <section className="py-24 bg-white">
          <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5 }}
              className="text-center mb-16"
            >
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4" style={{ letterSpacing: '-0.02em' }}>
                What our clients say
              </h2>
              <p className="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Real feedback from businesses we've helped grow
              </p>
            </motion.div>

            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
              {testimonials.map((testimonial, index) => (
                <motion.div
                  key={testimonial.name}
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  viewport={{ once: true }}
                  transition={{ duration: 0.5, delay: index * 0.1 }}
                >
                  <Card className="h-full">
                    <CardContent className="p-6">
                      <Quote className="text-primary mb-4" size={32} />
                      <p className="text-gray-700 mb-6 leading-relaxed">{testimonial.text}</p>
                      <div className="flex items-center gap-4">
                        <img
                          src={testimonial.image}
                          alt={testimonial.name}
                          className="w-12 h-12 rounded-xl object-cover"
                        />
                        <div>
                          <p className="font-semibold text-gray-900">{testimonial.name}</p>
                          <p className="text-sm text-gray-600">{testimonial.role}</p>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                </motion.div>
              ))}
            </div>
          </div>
        </section>

        <Footer />
      </div>
    </>
  );
};

export default HomePage;
