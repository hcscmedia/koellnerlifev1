<?php
/**
 * Kontakt - koellner.life
 */

require_once '../config.php';

// Formular-Verarbeitung
$form_success = false;
$form_error = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot Spam-Schutz
    if (!empty($_POST['website'])) {
        // Bot erkannt - Form wurde ausgefüllt aber nicht anzeigen
        header('Location: /pages/contact.php?success=1');
        exit;
    }
    
    // Eingaben validieren und sanitizen
    $name = isset($_POST['name']) ? trim(strip_tags($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
    $subject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : '';
    $message = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';
    
    // Validierung
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $form_error = true;
        $error_message = 'Bitte füllen Sie alle Felder aus.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_error = true;
        $error_message = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
    } else {
        // E-Mail versenden
        $to = CONTACT_EMAIL;
        $email_subject = "Kontaktanfrage von $name: $subject";
        $email_body = "Neue Kontaktanfrage von der Website\n\n";
        $email_body .= "Name: $name\n";
        $email_body .= "E-Mail: $email\n";
        $email_body .= "Betreff: $subject\n\n";
        $email_body .= "Nachricht:\n$message\n";
        
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        if (mail($to, $email_subject, $email_body, $headers)) {
            $form_success = true;
        } else {
            $form_error = true;
            $error_message = 'Leider ist ein Fehler aufgetreten. Bitte versuchen Sie es später erneut oder kontaktieren Sie mich direkt per E-Mail.';
        }
    }
}

// Success-Parameter aus URL prüfen
if (isset($_GET['success']) && $_GET['success'] == '1') {
    $form_success = true;
}

include '../includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1 class="page-title">Kontakt</h1>
        <p class="page-description">
            Lassen Sie uns über Ihr Projekt sprechen
        </p>
    </div>
</section>

<section class="contact-section section">
    <div class="container">
        <div class="contact-grid">
            <!-- Kontaktinformationen -->
            <div class="contact-info">
                <h2 class="contact-info-title">Schreiben Sie mir</h2>
                <p class="contact-info-text">
                    Haben Sie eine Frage, ein Projekt oder möchten Sie einfach Hallo sagen? 
                    Ich freue mich auf Ihre Nachricht und melde mich schnellstmöglich bei Ihnen.
                </p>
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <div class="contact-method-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="contact-method-content">
                            <h3 class="contact-method-title">E-Mail</h3>
                            <a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="contact-method-link">
                                <?php echo CONTACT_EMAIL; ?>
                            </a>
                        </div>
                    </div>
                    
                    <?php if (PHONE_NUMBER): ?>
                    <div class="contact-method">
                        <div class="contact-method-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="contact-method-content">
                            <h3 class="contact-method-title">Telefon</h3>
                            <a href="tel:<?php echo PHONE_NUMBER; ?>" class="contact-method-link">
                                <?php echo PHONE_NUMBER; ?>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="contact-method">
                        <div class="contact-method-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                <path d="M2 12h20" stroke="currentColor" stroke-width="2"/>
                                <path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="contact-method-content">
                            <h3 class="contact-method-title">Social Media</h3>
                            <div class="contact-social-links">
                                <?php if (SOCIAL_GITHUB): ?>
                                    <a href="<?php echo SOCIAL_GITHUB; ?>" target="_blank" rel="noopener" class="contact-social-link">GitHub</a>
                                <?php endif; ?>
                                <?php if (SOCIAL_LINKEDIN): ?>
                                    <a href="<?php echo SOCIAL_LINKEDIN; ?>" target="_blank" rel="noopener" class="contact-social-link">LinkedIn</a>
                                <?php endif; ?>
                                <?php if (SOCIAL_INSTAGRAM): ?>
                                    <a href="<?php echo SOCIAL_INSTAGRAM; ?>" target="_blank" rel="noopener" class="contact-social-link">Instagram</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-availability">
                    <div class="availability-badge">
                        <span class="availability-dot"></span>
                        Verfügbar für neue Projekte
                    </div>
                </div>
            </div>
            
            <!-- Kontaktformular -->
            <div class="contact-form-wrapper">
                <?php if ($form_success): ?>
                    <div class="alert alert-success">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22 4L12 14.01l-3-3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div>
                            <strong>Vielen Dank!</strong>
                            <p>Ihre Nachricht wurde erfolgreich gesendet. Ich melde mich schnellstmöglich bei Ihnen.</p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($form_error): ?>
                    <div class="alert alert-error">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M15 9l-6 6M9 9l6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <div>
                            <strong>Fehler!</strong>
                            <p><?php echo escape_html($error_message); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="contact-form" id="contactForm">
                    <!-- Honeypot Feld (versteckt für echte Benutzer) -->
                    <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Name *</label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            class="form-input" 
                            required
                            value="<?php echo isset($_POST['name']) ? escape_html($_POST['name']) : ''; ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">E-Mail *</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-input" 
                            required
                            value="<?php echo isset($_POST['email']) ? escape_html($_POST['email']) : ''; ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="subject" class="form-label">Betreff *</label>
                        <input 
                            type="text" 
                            id="subject" 
                            name="subject" 
                            class="form-input" 
                            required
                            value="<?php echo isset($_POST['subject']) ? escape_html($_POST['subject']) : ''; ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Nachricht *</label>
                        <textarea 
                            id="message" 
                            name="message" 
                            class="form-textarea" 
                            rows="6" 
                            required
                        ><?php echo isset($_POST['message']) ? escape_html($_POST['message']) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-large btn-full">
                        Nachricht senden
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" class="btn-icon">
                            <path d="M18 2L9 11M18 2l-5 16-3-7-7-3 16-5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
