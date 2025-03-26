:::mermaid
graph TD
    A[現代AI技術] --> B[機械学習]
    A --> C[知識ベースシステム]
    
    B --> D[教師あり学習]
    B --> E[教師なし学習]
    B --> F[強化学習]
    B --> G[深層学習/ニューラルネットワーク]
    
    G --> H[CNN - 畳み込みニューラルネットワーク]
    G --> I[RNN - 再帰型ニューラルネットワーク]
    G --> J[トランスフォーマー]
    
    J --> K[大規模言語モデル/LLM]
    
    K --> L1[OpenAI系]
    K --> L2[Google系]
    K --> L3[Anthropic系]
    K --> L4[Meta系]
    K --> L5[その他のLLM]
    
    L1 --> M1[GPT-3.5/GPT-4]
    M1 --> N1[ChatGPT]
    M1 --> N2[GitHub Copilot]
    M1 --> N3[Microsoft CoPilot]
    M1 --> N4[DALL-E]
    
    L2 --> M2[PaLM]
    L2 --> M3[Gemini]
    M2 --> N5[Bard]
    M3 --> N6[Google AI]
    
    L3 --> M4[Claude]
    M4 --> N7[Claude Web App]
    M4 --> N8[Claude API]
    
    L4 --> M5[LLaMA]
    M5 --> N9[Llama 2/3]
    M5 --> N10[その他のLLaMA派生モデル]
    
    L5 --> M6[Stable Diffusion]
    L5 --> M7[Midjourney]
    
    H --> O1[画像認識技術]
    O1 --> P1[顔認識システム]
    O1 --> P2[自動運転視覚システム]
    
    I --> O2[自然言語処理初期モデル]
:::