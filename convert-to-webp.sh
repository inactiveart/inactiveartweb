#!/bin/bash
# WebP Conversion Script for Inactiveart Portfolio Images
# This script converts existing portfolio images to WebP format

echo "🖼️  Converting portfolio images to WebP format..."

# Check if cwebp is installed
if ! command -v cwebp &> /dev/null; then
    echo "❌ cwebp is not installed. Installing via Homebrew..."
    brew install webp
fi

# Convert images in assets/img directory
if [ -d "assets/img" ]; then
    cd assets/img
    
    # Convert JPG files
    for img in *.jpg *.jpeg; do
        if [ -f "$img" ]; then
            filename="${img%.*}"
            echo "Converting $img to $filename.webp..."
            cwebp -q 85 "$img" -o "$filename.webp"
        fi
    done
    
    # Convert PNG files
    for img in *.png; do
        if [ -f "$img" ]; then
            filename="${img%.*}"
            echo "Converting $img to $filename.webp..."
            cwebp -q 85 "$img" -o "$filename.webp"
        fi
    done
    
    cd ../..
    echo "✅ WebP conversion complete!"
else
    echo "⚠️  assets/img directory not found"
fi

echo ""
echo "📊 WebP files created:"
find assets/img -name "*.webp" -type f 2>/dev/null || echo "No WebP files found"
