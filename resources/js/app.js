import Alpine from 'alpinejs';

import {
    ArrowDown,
    ArrowRight,
    Calendar,
    Car,
    CircleCheck,
    Clock,
    Crown,
    Eye,
    EyeOff,
    Heart,
    Map,
    MapPin,
    MessageCircle,
    Phone,
    Sparkles,
    Star,
    User,
    createIcons,
} from 'lucide';

import './catalogo-servicios';

createIcons({
    icons: {
        ArrowDown,
        ArrowRight,
        Calendar,
        Car,
        CircleCheck,
        Clock,
        Crown,
        Eye,
        EyeOff,
        Heart,
        Map,
        MapPin,
        MessageCircle,
        Phone,
        Sparkles,
        Star,
        User,
    },
});

window.Alpine = Alpine;

Alpine.start();
