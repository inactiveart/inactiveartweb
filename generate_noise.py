import wave
import random
import struct

# Parameters
duration = 10  # seconds
sample_rate = 44100
num_samples = duration * sample_rate
output_file = "assets/audio/ambient-drone.wav"

# Generate Brown Noise (Cumulative sum of random steps)
# This creates a "rumble" sound closer to a drone than harsh white noise
print(f"Generating {duration}s of Brown Noise to {output_file}...")

with wave.open(output_file, 'w') as wav_file:
    wav_file.setnchannels(1)  # Mono
    wav_file.setsampwidth(2)  # 2 bytes (16-bit)
    wav_file.setframerate(sample_rate)
    
    last_value = 0
    max_amp = 32767 * 0.1  # Limit volume to 10% (Drone should be subtle)
    
    for _ in range(num_samples):
        # Random step
        step = random.uniform(-1, 1)
        last_value += step
        
        # Leaky integrator to keep it centered (prevent drifting to infinity)
        last_value -= last_value * 0.02
        
        # Clip to limits
        sample_val = max(min(last_value * 500, max_amp), -max_amp)
        
        # Write frame
        wav_file.writeframes(struct.pack('<h', int(sample_val)))

print("Done.")
