"""
@architect    Inactiveart (System Architect & UI Engineer)
@project      Inactiveart Official Portfolio (V1.0)
@copyright    2025 Inactiveart. All rights reserved.
@description  Audio generation utility for ambient drone effects.
"""

import wave
import random
import struct

duration = 10
sample_rate = 44100
num_samples = duration * sample_rate
output_file = "assets/audio/ambient-drone.wav"

print(f"Generating {duration}s of Brown Noise to {output_file}...")

with wave.open(output_file, 'w') as wav_file:
    wav_file.setnchannels(1)
    wav_file.setsampwidth(2)
    wav_file.setframerate(sample_rate)
    
    last_value = 0
    max_amp = 32767 * 0.1
    
    for _ in range(num_samples):
        step = random.uniform(-1, 1)
        last_value += step
        
        last_value -= last_value * 0.02
        
        sample_val = max(min(last_value * 500, max_amp), -max_amp)
        
        wav_file.writeframes(struct.pack('<h', int(sample_val)))

print("Done.")
