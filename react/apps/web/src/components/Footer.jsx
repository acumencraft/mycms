
import React from 'react';
import { Link } from 'react-router-dom';
import { Mail, Phone, MapPin } from 'lucide-react';

const Footer = () => {
  return (
    <footer className="bg-gray-950 text-gray-300 py-12">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
          <div>
            <span className="text-2xl font-bold text-white mb-4 block">archvadze</span>
            <p className="text-sm leading-relaxed">
              Building exceptional digital experiences for businesses worldwide. Your vision, our expertise.
            </p>
          </div>

          <div>
            <span className="text-white font-semibold mb-4 block">Quick Links</span>
            <nav className="space-y-2">
              <Link to="/services" className="block text-sm hover:text-white transition-colors">Services</Link>
              <Link to="/portfolio" className="block text-sm hover:text-white transition-colors">Portfolio</Link>
              <Link to="/calculator" className="block text-sm hover:text-white transition-colors">Price Calculator</Link>
              <Link to="/order" className="block text-sm hover:text-white transition-colors">Order Now</Link>
            </nav>
          </div>

          <div>
            <span className="text-white font-semibold mb-4 block">Contact</span>
            <div className="space-y-3">
              <div className="flex items-center gap-2 text-sm">
                <Mail size={16} />
                <span>info@archvadze.com</span>
              </div>
              <div className="flex items-center gap-2 text-sm">
                <Phone size={16} />
                <span>+995 555 123 456</span>
              </div>
              <div className="flex items-center gap-2 text-sm">
                <MapPin size={16} />
                <span>Tbilisi, Georgia</span>
              </div>
            </div>
          </div>
        </div>

        <div className="pt-8 border-t border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
          <p className="text-sm">© 2026 archvadze. All rights reserved.</p>
          <div className="flex gap-6">
            <Link to="/privacy" className="text-sm hover:text-white transition-colors">Privacy Policy</Link>
            <Link to="/terms" className="text-sm hover:text-white transition-colors">Terms of Service</Link>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
