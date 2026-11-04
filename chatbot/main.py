"""
LDTECS chatbot - STATIC version (no AI, no API keys, no internet calls).
Every reply is pre-written below. API-only backend for the Laravel LDTECS website; it does not serve a separate HTML page.

Run:  pip install fastapi uvicorn
      python main.py
"""
import re
from typing import List, Optional

import uvicorn
from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
from pydantic import BaseModel

# API only: Laravel serves the LDTECS website; this service only returns chatbot replies.
app = FastAPI(title="LDTECS Static Chatbot API")
app.add_middleware(CORSMiddleware, allow_origins=["*"], allow_methods=["*"], allow_headers=["*"])

SITE = "https://ldtecs.onrender.com/"
EMAIL = "info@ldtecs.com"


class ChatRequest(BaseModel):
    msg: Optional[str] = None
    messages: Optional[List[dict]] = None
    history: Optional[List[dict]] = None

    def latest_message(self) -> str:
        if self.msg and self.msg.strip():
            return self.msg.strip()

        if self.messages:
            for item in reversed(self.messages):
                if isinstance(item, dict) and item.get("role") == "user":
                    content = item.get("content", "")
                    if isinstance(content, str) and content.strip():
                        return content.strip()

        return ""


# ── Clickable cards (title, small text, link) ────────────────────────────────
def card(title, sub, url, ask=None):
    """ask = message sent to the chat when the box is clicked (shows data in the chat)."""
    return {"title": title, "sub": sub, "url": url, "ask": ask}

C_ELITE = card("Classifier Elite", "300 x 280 x 320 mm", SITE + "elite", "Classifier Elite details")
C_LITE = card("Classifier Lite", "180 x 250 x 190 mm", SITE + "lite", "Classifier Lite details")
C_NANO = card("Classifier Nano", "150 x 150 x 160 mm", SITE + "nano", "Classifier Nano details")
C_SOFT = card("Software Development", "Custom software, web apps, APIs", SITE + "software-development", "Software Development details")
C_AI = card("AI & Machine Learning", "ML models, computer vision, automation", SITE + "machine-learning", "AI & Machine Learning details")
C_3D = card("3D Printing", "Rapid prototyping, custom components", SITE + "3d-printing", "3D Printing details")
C_RND = card("R&D Services", "Concept, PoC, prototype, validation", SITE + "r&d-services", "R&D Services details")
C_CONTACT = card("Contact page", "Send us your inquiry", SITE + "contact")
C_EMAIL = card("Email us", EMAIL, "mailto:" + EMAIL)
C_WHATSAPP = card("WhatsApp", "9054005433", "https://wa.me/919054005433")
# C_WHATSAPP1 = card("WhatsApp", "99033793379", "https://wa.me/9199033793379")
C_SITE = card("LDTECS Website", SITE, SITE)

PRODUCT_CARDS = [C_ELITE, C_LITE, C_NANO]
SERVICE_CARDS = [C_SOFT, C_AI, C_3D, C_RND]
CONTACT_CARDS = [C_EMAIL, C_WHATSAPP, C_CONTACT]


def page_cards(slug: str) -> list:
    return [
        C_EMAIL,
        C_WHATSAPP
    ]
    # """Boxes shown on every product / service detail reply:
    # open the website page, email, and both WhatsApp numbers (always visible)."""
    # url = SITE + slug
    # return [card("Open full webpage", url, url), C_EMAIL, C_WHATSAPP, C_WHATSAPP1]


def R(text, cards=None):
    return {"response": text, "cards": cards or []}


# ── Pre-written replies ───────────────────────────────────────────────────────
SERVICES = R(
    "Overview of our services:\n\n"
    "Technology Solutions: we build intelligent software and AI-driven systems to solve "
    "real-world problems and help businesses grow.\n"
    "• Software Development: custom software, modern web applications, APIs and scalable "
    "digital solutions.\n"
    "• AI & Machine Learning: intelligent systems, data analysis, image recognition and automation.\n\n"
    "Design & Prototyping: we turn your ideas into accurate designs and physical prototypes.\n"
    "• 3D Printing: rapid prototyping and physical models from digital 3D designs.\n"
    "• R&D Services: feasibility studies, proof of concept, prototyping and technical validation.\n\n"
    "Open a page for details:",
    SERVICE_CARDS,
)
PRODUCTS = R(
    "Overview of our products:\n\n"
    "LDTECS makes Diamond Detectors under the CLASSIFIER series, available in three models:\n"
    "• Elite: the largest model, 300 x 280 x 320 mm\n"
    "• Lite: 180 x 250 x 190 mm\n"
    "• Nano: the compact, wireless model, 150 x 150 x 160 mm\n\n"
    "Tap a box to see its details:",
    PRODUCT_CARDS,
)
CONTACT = R(
    "Overview: you can reach the LDTECS team by email or through the contact page. "
    "Our headquarters is in Surat, Gujarat 395004, India.\n\nOpen one of these to get in touch:",
    CONTACT_CARDS,
)
PRICING = R(
    "Pricing isn't listed on our website. Quotations come directly from our team. "
    "Please contact us with a short description of what you need.",
    CONTACT_CARDS,
)
ABOUT = R(
    "Overview: LDTECS (Technology. Engineering Tomorrow.) is based in Surat, Gujarat, India.\n\n"
    "• Products: Diamond Detectors, the CLASSIFIER series (Elite, Lite, Nano)\n"
    "• Technology Solutions: Software Development, AI & Machine Learning\n"
    "• Design & Prototyping: 3D Printing, R&D Services\n\n"
    "Want to know more? Ask about our products, services or contact details.",
)
FALLBACK = R(
    "I'm not sure about that one. I can help with our Diamond Detectors, our services, "
    f"or contact details. For anything else, email {EMAIL}.",
    [C_EMAIL],
)


# ── Product data (copied from the website product pages) ─────────────────────
PRODUCT_DATA = {
    "elite": {
        "title": "CLASSIFIER ELITE",
        "about": ("AI-powered lab-grown diamond screening. Detects synthetic diamonds (CVD, HPHT) "
                  "and simulants (Cubic Zirconia, Moissanite). Results in 25-40 seconds."),
        "facts": [
            ("Detects", "CVD/HPHT & treated"),
            ("Accuracy", "98%+ synthetic, 70% simulant"),
            ("Size", "0.001 cts and larger"),
            ("Colors", "D to K"),
            ("Scanning time", "25-40 seconds"),
            ("Works on", "Loose & mounted, all shapes, rough & polished"),
        ],
        "specs": [
            ("Scanning area", "190 x 140 mm"),
            ("Dimension (W x L x H)", "300 x 280 x 320 mm"),
            ("Weight", "10 KG"),
            ("Power supply", "100-240V, 5A"),
            ("Software", "Standalone Linux OS"),
            ("Local storage", "256 GB"),
            ("Cloud storage", "15 GB"),
            ("Connectivity", "USB / Wi-Fi"),
            ("Display", "Full HD IPS display"),
        ],
        "features": [
            "Identifies synthetic and simulant diamonds (CVD, HPHT, CZ, treated)",
            "Advanced AI algorithms for high-confidence detection",
            "Detects loose diamonds and diamonds mounted in jewellery",
            "Simple, user-friendly software interface",
            "Tamper-proof and consistently reliable operation",
            "16 MP auto-focus camera, 20X+ zoom",
            "Email sharing, custom theme reports, QR code for report URL",
            "Auto-save and auto-delete of old records",
        ],
        "accessories": ("Diamond tray (220 x 200 mm), bangle tray, ring tray, necklace tray, "
                        "bangle / bracelet / ring holders, display, wireless keyboard & mouse, "
                        "adapter & power supply, packaging bag"),
    },
    "lite": {
        "title": "CLASSIFIER LITE",
        "about": ("Screens natural diamonds, lab-grown diamonds (CVD, HPHT) and simulants such as CZ. "
                  "Results in 18-25 seconds, with 15X zoom, UV fluorescent light and multiple screening modes."),
        "facts": [
            ("Detects", "CVD/HPHT & treated"),
            ("Accuracy", "98%+"),
            ("Size", "0.001 cts and larger"),
            ("Colors", "D to K"),
            ("Scanning time", "18-25 seconds"),
            ("Works on", "Loose & mounted, all shapes, rough & polished"),
        ],
        "specs": [
            ("Scanning time", "18-25 seconds"),
            ("Dimension (W x L x H)", "180 x 250 x 190 mm"),
            ("Window size", "125 x 90 mm"),
            ("Diamond tray size", "70 x 100 mm"),
            ("Ring tray", "Scans 24 rings at a time"),
            ("Colour range / size", "D to K / above 0.003 carats"),
            ("Power", "Mobile charger / power bank"),
            ("Machine storage", "256 GB"),
            ("Software upgrades", "Stay up to date with latest updates"),
        ],
        "features": [
            "Comprehensive detection: natural, lab-grown (CVD, HPHT) and simulants like CZ",
            "Scans loose diamonds and small jewellery (necklaces, earrings, bangles and more)",
            "Smart auto-marking of diamonds",
            "Internal UV fluorescent light to reduce false positives",
            "Auto-save / manual save with name, lot number; 256 GB storage and in-app gallery",
            "Certificate generation with company branding",
            "Record sharing via email or mobile sharing",
            "15X zoom for precision",
            "Single, double and quad screening modes",
        ],
        "accessories": ("Ring tray (140 x 100 mm), diamond tray (140 x 100 mm), bangle / bracelet / "
                        "ring holders, smartphone, adapter & power cable, packaging bag"),
    },
    "nano": {
        "title": "CLASSIFIER NANO",
        "about": ("Compact, wireless lab-grown diamond screening. Detects synthetic diamonds (CVD, HPHT), "
                  "simulants such as CZ and treated diamonds. Results in 20-30 seconds per tray."),
        "facts": [
            ("Detects", "CVD/HPHT & treated"),
            ("Accuracy", "Up to 98% synthetic, 70% simulant"),
            ("Size", "0.001 cts and larger"),
            ("Colors", "D to K"),
            ("Scanning time", "20-30 seconds per tray"),
            ("Works on", "Loose diamonds and jewellery like rings and earrings"),
        ],
        "specs": [
            ("Dimensions (W x L x H)", "150 x 150 x 160 mm"),
            ("Weight", "2 kg"),
            ("Power supply", "100-240V AC, 50/60 Hz"),
            ("Operating system", "Standalone Linux"),
            ("Detection accuracy", "Up to 98%"),
            ("Detection time", "20-30 seconds / tray"),
            ("Camera", "16 MP auto-focus"),
            ("Connectivity", "Wi-Fi"),
            ("Compatible devices", "Android mobile, laptop & desktop (wireless web interface)"),
        ],
        "features": [
            "Identifies synthetic and simulant diamonds (CVD, HPHT, CZ, treated)",
            "Advanced AI algorithms for high-confidence detection",
            "Compact, lightweight, durable; fits in a small bag for travel and client meetings",
            "Runs through your connected mobile, laptop or screen",
            "Saves data to your connected device; email sharing",
            "Custom theme reports and QR code for report URL",
            "Auto-save and auto-delete of old records",
        ],
        "accessories": "Ring tray, diamond tray, adapter & power cable, packaging bag",
    },
}


def product_detail(key: str) -> dict:
    p = PRODUCT_DATA[key]
    lines = [p["title"], p["about"], "", "QUICK FACTS"]
    lines += [f"• {k}: {v}" for k, v in p["facts"]]
    lines += ["", "TECHNICAL SPECIFICATIONS"]
    lines += [f"• {k}: {v}" for k, v in p["specs"]]
    lines += ["", "KEY FEATURES"]
    lines += [f"• {f}" for f in p["features"]]
    lines += ["", "INCLUDED ACCESSORIES", p["accessories"]]
    return R("\n".join(lines), page_cards(key))


SERVICE_DATA = {
    "software": {
        "title": "SOFTWARE DEVELOPMENT",
        "group": "Technology Solutions",
        "about": "Custom software, modern web applications, APIs and scalable digital solutions.",
        "covers": ["Custom software", "Web applications", "Frontend and backend development",
                   "Database and API integration", "Maintenance and support"],
        "slug": "software-development",
    },
    "ai": {
        "title": "AI & MACHINE LEARNING",
        "group": "Technology Solutions",
        "about": "Intelligent systems, data analysis, image recognition and automation.",
        "covers": ["ML models", "Predictive analytics", "Computer vision",
                   "AI-powered automation", "Data analysis and integration"],
        "slug": "machine-learning",
    },
    "3d": {
        "title": "3D PRINTING",
        "group": "Design & Prototyping",
        "about": "Rapid prototyping and physical models from digital 3D designs.",
        "covers": ["Rapid prototyping", "Custom components", "Design verification",
                   "Product model printing"],
        "slug": "3d-printing",
    },
    "rnd": {
        "title": "R&D SERVICES",
        "group": "Design & Prototyping",
        "about": "Feasibility studies, proof of concept, prototyping and technical validation.",
        "covers": ["Concept development", "Proof of concept (PoC)", "Prototype development",
                   "Testing and validation"],
        "slug": "r&d-services",
    },
}


def service_detail(key: str) -> dict:
    d = SERVICE_DATA[key]
    lines = [d["title"], f"Part of {d['group']}.", "", "OVERVIEW", d["about"], "", "WHAT IT COVERS"]
    lines += [f"• {x}" for x in d["covers"]]
    lines += ["", "For a quote, timeline or custom project, please contact the team."]
    return R("\n".join(lines), page_cards(d["slug"]))


SERVICE_PAGES = {k: service_detail(k) for k in SERVICE_DATA}

CHIPS = {  # exact texts of the suggestion chips in home.html
    "about ldtecs": ABOUT,
    "our products": PRODUCTS,
    "our services": SERVICES,
    "contact & support": R(
        "Overview: for sales, support or technical questions, email the LDTECS team or use "
        "the contact page. Headquarters: Surat, Gujarat 395004, India.\n\n"
        "Open one of these to get in touch:",
        CONTACT_CARDS,
    ),
}


def has(m: str, words) -> bool:
    """Whole-word / whole-phrase match (so 'fee' won't match 'coffee')."""
    return any(re.search(rf"(?<!\w){re.escape(w)}(?!\w)", m) for w in words)


def get_static_response(message: str) -> dict:
    m = message.lower().strip()
    c = m.rstrip("?!. ")

    if c in CHIPS:
        return CHIPS[c]

    # Greetings, thanks, goodbye
    if c in ["hi", "hello", "hey", "hiya", "howdy", "greetings", "good morning",
             "good afternoon", "good evening", "good day", "namaste", "hii", "hlo"]:
        return R("Hello! Welcome to LDTECS. How can I help you today?")
    if c in ["bye", "goodbye", "see you", "see ya", "take care", "later", "good night", "cya"]:
        return R("Goodbye! Feel free to reach out anytime. Have a great day! 👋")
    if c in ["thanks", "thank you", "thank you so much", "thx", "ty", "thanks a lot",
             "many thanks", "cheers"]:
        return R("You're welcome! Is there anything else I can help you with?")
    if c in ["help", "support", "i need help", "i need support", "can you help me", "how can you help"]:
        return R("Of course! I can tell you about our Diamond Detectors, our services, "
                 "or how to contact the team. What do you need?")

    # Bot identity
    if has(m, ["who are you", "what are you", "are you a bot", "are you human",
               "are you ai", "are you a robot", "your name", "what is your name"]):
        return R("I'm the LDTECS assistant. I can answer common questions about LDTECS. How can I help?")

    # Company
    if has(m, ["what is ldtecs", "who is ldtecs", "about ldtecs", "tell me about ldtecs",
               "about company", "about the company", "about us", "what does ldtecs do"]):
        return ABOUT
    if has(m, ["your website", "ldtecs website", "official website", "site url", "web address"]):
        return R("Tap the box to open our official website:", [C_SITE])

    # Pricing first, so "price of nano" gets the pricing answer
    if has(m, ["price", "prices", "pricing", "cost", "costs", "fee", "fees", "quote",
               "quotation", "how much", "rate", "rates", "discount"]):
        return PRICING

    # Specific products (matched anywhere in the sentence)
    for key in ("elite", "lite", "nano"):
        if has(m, [key, f"classifier {key}"]):
            return product_detail(key)
    if has(m, ["compare", "difference", "which is better", "vs"]) and has(m, ["classifier", "elite", "lite", "nano", "detector"]):
        return R(
            "Our website lists these sizes: Elite 300 x 280 x 320 mm, Lite 180 x 250 x 190 mm, "
            "Nano 150 x 150 x 160 mm. For a recommendation for your needs, contact us.",
            PRODUCT_CARDS + [C_EMAIL, C_WHATSAPP],
        )
    if has(m, ["product", "products", "diamond detector", "diamond detectors", "detector",
               "classifier"]):
        return PRODUCTS

    # Specific services
    if has(m, ["3d printing", "3d print", "3d printer", "prototype printing"]):
        return SERVICE_PAGES["3d"]
    if has(m, ["r&d", "research and development", "proof of concept", "poc", "feasibility"]):
        return SERVICE_PAGES["rnd"]
    if has(m, ["machine learning", "ml", "ai", "artificial intelligence", "computer vision",
               "ai & machine learning", "ai and machine learning"]):
        return SERVICE_PAGES["ai"]
    if has(m, ["software", "software development", "website", "web app", "web application",
               "app", "api", "web development"]):
        return SERVICE_PAGES["software"]
    if has(m, ["service", "services", "offer", "offerings", "what do you provide", "what do you do"]):
        return SERVICES

    # Hours, location, contact, social, clients
    if has(m, ["working hours", "office hours", "business hours", "opening hours", "when are you open"]):
        return R("Working hours aren't listed on our website. Please contact us.", CONTACT_CARDS)
    if has(m, ["address", "where are you", "headquarters", "head office", "office", "location",
               "located", "based"]):
        return R("LDTECS corporate headquarters: Surat, Gujarat 395004, India.", [C_CONTACT])
    if has(m, ["contact", "reach", "get in touch", "phone", "call", "email", "e-mail",
               "mail", "whatsapp", "number"]):
        return CONTACT
    if has(m, ["facebook", "instagram", "twitter", "linkedin", "youtube", "social media"]):
        return R("Social media links aren't listed on our website. Please check our website or email us.",
                 [C_SITE, C_EMAIL])
    if has(m, ["client", "clients", "customer", "customers"]):
        return R(
            "Our website lists clients including Seven Star, Tenx, Uni Design, Mahavir, "
            "Shivaye Diamonds, Hari Krishna, Mahindra Diamonds, Manisha Gems and Nature's Art LTD.")
    if has(m, ["demo", "order", "buy", "purchase", "custom project", "timeline", "delivery"]):
        return R("For purchases, demos, custom projects or timelines, please contact us. Mention what "
                 "you need, your business type, any deadline, and your contact details.", CONTACT_CARDS)
    if has(m, ["support", "help", "issue", "problem", "warranty"]):
        return R("For support and technical questions, please contact us.", CONTACT_CARDS)

    return FALLBACK


@app.get("/health")
async def health():
    return {"status": "ok", "service": "LDTECS chatbot API"}


@app.post("/api/level2/chat")
async def chat(body: ChatRequest):
    message = body.latest_message()
    if not message:
        return JSONResponse(
            {"response": "Please type a message and try again.", "cards": []},
            status_code=400,
        )
    return JSONResponse(get_static_response(message))


if __name__ == "__main__":
    uvicorn.run(
        app,
        host="127.0.0.1",
        port=8082,
        reload=False
    )