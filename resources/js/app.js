import Alpine from 'alpinejs';

import {
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
