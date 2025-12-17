from flask import Flask, jsonify, request
from flask_flasgger import Swagger
from models import db, Product, Feedback, User, Order 
import os
basedir = os.path.abspath(os.path.dirname(__file__))
app = Flask(__name__)
swagger = Swagger(app) 
app.config['SQLALCHEMY_DATABASE_URI'] = 'sqlite:///' + os.path.join(basedir, 'shop.db')
app.config['SECRET_KEY'] = 'api_secret_key'
db.init_app(app)

@app.errorhandler(404)
def resource_not_found(e):
    return jsonify(error=str(e)), 404

@app.route('/api/products', methods=['GET'])
def get_products():
    """
    API endpoint для перегляду всіх товарів.
    ---
    responses:
      200:
        description: Список товарів
    """
    products = Product.query.all()
    return jsonify([{'id': p.id, 'name': p.name, 'price': p.price} for p in products])

@app.route('/api/products/<int:id>', methods=['GET'])
def get_product(id):
    product = Product.query.get_or_404(id)
    return jsonify({'id': product.id, 'name': product.name, 'description': product.description, 'price': product.price})

@app.route('/api/feedback', methods=['POST'])
def create_feedback():
    data = request.get_json()
    if not data or 'text' not in data:
        return jsonify({'error': 'Missing feedback text'}), 400
    new_feedback = Feedback(text=data, rating=data.get('rating', 5))
    db.session.add(new_feedback)
    db.session.commit()
    return jsonify({'message': 'Feedback created', 'id': new_feedback.id}), 201

@app.route('/api/feedback', methods=['GET'])
def get_feedback():
    feedbacks = Feedback.query.all()
    return jsonify()

@app.route('/api/feedback/<int:id>', methods=['DELETE'])
def delete_feedback(id):
    feedback = Feedback.query.get_or_404(id)
    db.session.delete(feedback)
    db.session.commit()
    return jsonify({'message': 'Feedback deleted'}), 200

@app.route('/api/orders', methods=['POST'])
def create_order():
    return jsonify({'message': 'Order creation logic goes here'})

if __name__ == '__main__':
    with app.app_context():
        db.create_all()
    app.run(debug=True, port=5001)
