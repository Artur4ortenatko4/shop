from flask import Flask, render_template, request, redirect, url_for
from flask_admin import Admin
from flask_admin.contrib.sqla import ModelView
from models import db, Product, Feedback, User, Order
import os
basedir = os.path.abspath(os.path.dirname(__file__))
app = Flask(__name__)
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///' + os.path.join(basedir, 'shop.db')
app.config['SECRET_KEY'] = 'your_secret_key'
db.init_app(app)
admin = Admin(app, name='Shop Admin Panel', template_mode='bootstrap3')
admin.add_view(ModelView(Product, db.session))
admin.add_view(ModelView(Feedback, db.session))
admin.add_view(ModelView(User, db.session))
admin.add_view(ModelView(Order, db.session))
@app.route('/')
def index():
    products = Product.query.all()
    return render_template('index.html', products=products)
@app.route('/feedback', methods=['GET', 'POST'])
def feedback_page():
    if request.method == 'POST':
        text = request.form.get('feedback_text')
        new_feedback = Feedback(text=text, rating=5) 
        db.session.add(new_feedback)
        db.session.commit()
        return redirect(url_for('feedback_page'))
    feedbacks = Feedback.query.all()
    return render_template('feedback.html', feedbacks=feedbacks)
if __name__ == '__main__':
    with app.app_context():
        db.create_all() 
    app.run(debug=True)
